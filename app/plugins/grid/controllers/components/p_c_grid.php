<?php
/**
 * TODO:
 * 1. проблема с loadModel. Если модель не была загружена в заголовке контроллера - не работает.
 * Пример:
 * function regionsList() {
		$this->loadModel('regions.Region');
		$this->grid['Region'] = array(
			'fields' => array('id', 'name'),
			'captions' => array('name' => __('Region name', true))
		);
		$this->PCGrid->paginate('Region');
	}
	Причина - при редактировании записи обрабатывается событие, которое связывается на этапе beforeFilter
 *	Возможные решения - при необходимости указывать префикс плагина и загружать можель при обработке события
 * 
 * 2. Отрефакторить код так, чтобы был общий пул инфы по полям. Отдельно иметь массив отображаемых полей _fields
 * Причина - необходимо для рендеринга hidden фильтров
 * 
 * 3. Вынести фрагменты кода для рендеринга (форма редактирования - !) в отдельные элементы, хелперы и т.д.
 * Причина - сократить код.
 * 
 * 4. Исключить primary key из списка readonly.
 * Причина - нехер его показывать либо показывать, но по требованию
 */

class PCGridComponent extends Object {
	var $_;
	var $modelName, $alias;
	var $allowedTypes = array('boolean', 'date', 'datetime', 'integer', 'string', 'text');
	
	// called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller = &$controller;
		$this->_ = &$controller;
	}

	//called after Controller::beforeFilter()
	function startup() {
		if ($this->_->params['action'] == 'gridAction') { // проверяем на стд.метод
			// перехватываем метод для Grid
			/*
			if ($this->_->params['named']['action'] == 'delete') {
				$this->deleteItems($this->params['named']['model'], $this->params['named']['del']);
			}
			*/
			$method = $this->_->params['named']['action'];
			$this->$method();
			
			$back_url = $this->_->params['url']['back_url'];
			/*
			if (isset($this->params['url']['back_url'])) {
				$back_url = $this->params['url']['back_url'];
				
			} else {
				// невозможно определить обратный URL, либо был попорчен, либо вызывали вручную без параметра back_url
				$back_url = '/'.$this->params['controller'];
			}
			*/
			$this->_->redirect($back_url);
			exit;
		}
	}
/*
	//called after Controller::beforeRender()
	function beforeRender(&$controller) {
	}

	//called after Controller::render()
	function shutdown(&$controller) {
	}

	//called before Controller::redirect()
	function beforeRedirect(&$controller, $url, $status=null, $exit=true) {
	}

	function redirectSomewhere($value) {
		// utilizing a controller method
		$this->controller->redirect($value);
	}
*/
	function paginate($modelName, $aConditions = array()) {
		/*
		$model = $this->_->$modelName;
		$grid = $this->_->$grid;
		*/
		$this->modelName = $modelName;
		$this->alias = $this->_->$modelName->alias;
		
		// fdebug($this->_->$modelName);
		
		// Handle fields
		$this->_initFields();
		$this->_initCaptions();
		$this->_initTypes();
		$this->_initFilters();
		$this->_initOrder();
		$this->_initPagination();
		$this->_initFiltersSize(); // должна быть после _initPagination(), т.к. использует ['rowset']
		$this->_initEdit();
		
		$this->_->grid[$modelName]['alias'] = $this->alias;
		
		// fdebug($this->_->grid, 'grid.log');
		$this->controller->set('grid', $this->_->grid);
		
		return $this->_->grid[$modelName]['rowset'];
	}
	
	function _normalizeField($modelName, $field) {
		if (strpos($field, '.') === false) {
			$field = $modelName.'.'.$field;
		}
		return $field;
	}
	
	function _denormalizeField($field) {
		$aInfo = explode('.', $field);
		return array('model' => $aInfo[0], 'field' => $aInfo[1]);
	}
	
	function _normalizeKeys($modelName, $aSrc) {
		$aDest = array();
		// Normalize fields
		foreach($aSrc as $field => $value) {
			$aDest[$this->_normalizeField($modelName, $field)] = $value;
		}
		return $aDest;
	}
	
	function _normalizeValues($modelName, $aSrc) {
		$aDest = array();
		// Normalize fields
		foreach($aSrc as $field) {
			$aDest[] = $this->_normalizeField($modelName, $field);
		}
		return $aDest;
	}
	
	function _initFields() {
		$modelName = $this->modelName;
		$aFields = (isset($this->_->grid[$modelName]['fields'])) ? $this->_->grid[$modelName]['fields'] : array_keys($this->_->$modelName->_schema);
		$aFields = $this->_normalizeValues($this->alias, $aFields);
		foreach($aFields as $fieldID) {
			$this->_->grid[$modelName]['_fields'][$fieldID] = $this->_denormalizeField($fieldID);
		}
	}
	
	function _initCaptions() {
		$aCaptions = array();
		if (isset($this->_->grid[$this->modelName]['captions'])) {
			$aCaptions = $this->_normalizeKeys($this->alias, $this->_->grid[$this->modelName]['captions']);
		}
		
		// заголовков может не хватать на все поля, поэтому обрабатываем все поля
		foreach($this->_->grid[$this->modelName]['_fields'] as $fieldID => $fieldInfo) {
			if (!isset($aCaptions[$fieldID])) {
				$caption = __(ucfirst(str_replace('_', ' ', $fieldInfo['field'])), true);
			} else {
				$caption = $aCaptions[$fieldID];
			}
			$this->_->grid[$this->modelName]['_fields'][$fieldID]['caption'] = $caption;
		}
	}
	
	/**
	 * Инициализация типов полей ($grid[$modelName][$fieldID]['type']). 
	 * Возможные значения типов для полей:
	 * string (по умолчанию), integer, float, date, datetime, text, boolean.
	 */
	function _initTypes() {
		$aTypes = array();
		if (isset($this->_->grid[$this->modelName]['types'])) {
			$aTypes = $this->_normalizeKeys($this->alias, $this->_->grid[$this->modelName]['types']);
		}
		
		// типов может не хватать на все поля, поэтому обрабатываем все поля
		foreach($this->_->grid[$this->modelName]['_fields'] as $fieldID => $fieldInfo) {
			if (!isset($aTypes[$fieldID])) {
				// вычисляем класс, по схеме которого будем определять тип
				// т.к. поле это alias.field_id, то для таких полей надо брать схему из изначальной модели,
				// а не из модели, соответствующей алиасу
				// с другой стороны, может быть задано поле, соотв-ее другой (связанной) модели
				// тогда вычисляем тип поля по своей модели
				$model = ($fieldInfo['model'] == $this->alias) ? $this->modelName : $fieldInfo['model'];
				$type = (isset($this->_->$model->_schema[$fieldInfo['field']]['type'])) ? $this->_->$model->_schema[$fieldInfo['field']]['type'] : 'undefined'; // по идее таких случаев не должно быть
			} else {
				$type = $aTypes[$fieldID];
			}
			if (!in_array($type, $this->allowedTypes)) {
				$type = 'string';
			}
			$this->_->grid[$this->modelName]['_fields'][$fieldID]['type'] = $type;
		}
	}
	
	/**
	 * Инициализация полей фильтра (_filters). Поля для фильтра заполняются след.элементами:
	 * filterType - тип поля для фильтра. Возможные значения: text, date_picker, dropdown.
	 * filterOptions - параметры для поля фильтра. Заполняется автоматически либо передается в зав-ти от типа фильтра.
	 * id - ID для HTML-кода фильтра. Заполняется автоматически.
	 * value - значение для поля фильтра. Заполняется автоматически.
	 * conditions - условие поиска по данному полю. Аналогичен $paginate['conditions'], но содержит только один элемент
	 * 		с текстовым значением: model.field => 'SQL expr({$value})'. Вместо '{$value}' подставляется значение из элемента
	 * 		$grid['_filters']['value']. 
	 * 
	 */
	function _initFilters() {
		$aFilters = array();
		if (isset($this->_->grid[$this->modelName]['filters'])) {
			$aFilters = $this->_normalizeKeys($this->alias, $this->_->grid[$this->modelName]['filters']);
		}
		foreach($this->_->grid[$this->modelName]['_fields'] as $fieldID => $fieldInfo) {
			if (!isset($aFilters[$fieldID]['filterType'])) {
				// определеяем тип поля для фильтра по типу поля для вывода
				$filterType = 'text'; // тип фильтра по умолчанию
				if ($fieldInfo['type'] == 'date' || $fieldInfo['type'] == 'datetime') {
					$filterType = 'date_picker';
				} elseif ($fieldInfo['type'] == 'boolean') {
					$filterType = 'dropdown';
				}
				$aFilters[$fieldID]['filterType'] = $filterType;
			}
			
			if (!isset($aFilters[$fieldID]['filterOptions'])) {
				// определеяем опции поля для фильтра по типу поля
				$filterOptions = array(); // опции фильтра по умолчанию
				if ($fieldInfo['type'] == 'boolean') {
					$filterOptions = array('1' => __('yes', true), '0' => __('no', true));
				}
				$aFilters[$fieldID]['filterOptions'] = $filterOptions;
			}
			// преобразуем ID поля для фильтра - нужно для корректного вывода в HTML (ModelName.some_field => ModelName__some_field)
			// для поля $fieldID может быть установлен фильтр по другому полю
			// напр. для Category.title может быть установлен Category.id
			$id = $fieldID;
			if (isset($aFilters[$fieldID]['id'])) {
				$id = $aFilters[$fieldID]['id'];
			}
			$aFilters[$fieldID]['id'] = str_replace('.', '__', $id);
			
			// сохраняем значение фильтра для вывода в поля фильтра
			if (!isset($aFilters[$fieldID]['value'])) { // если не задано значение по умолчанию
				$value = '';
				if (isset($this->_->params['named'][$fieldID])) {
					$value = $this->_->params['named'][$fieldID];
				}
				$aFilters[$fieldID]['value'] = $value;
			}
			
		}
		
		$this->_->grid[$this->modelName]['_filters'] = $aFilters;
		$this->_validateFilters();
	}
	
	function _validateFilters() {
		$this->_->grid[$this->modelName]['_filtersValid'] = true;
		foreach($this->_->grid[$this->modelName]['_filters'] as $fieldID => &$filterInfo) {
			if ($filterInfo['filterType'] == 'text' || $filterInfo['filterType'] ==  'date_picker') {
				// валидация нужна только для тех полей, которые вводятся вручную
				
				if ($filterInfo['value'] !== '' && isset($this->_->grid[$this->modelName]['_fields'][$fieldID])) {
					// если установлено значение фильтра и тип поля таблицы, значит можно делать валидацию
					$type = $this->_->grid[$this->modelName]['_fields'][$fieldID]['type'];
					
					// string (по умолчанию), enum, integer, float, date, datetime, text, boolean.
					$errMsg = '';
					if ($type == 'integer') {
						$errMsg = $this->_validateInteger($filterInfo['value']);
					} elseif ($type == 'date' || $type == 'datetime') {
						$errMsg = $this->_validateDate($filterInfo['value']);
					}
					
					if ($errMsg) {
						$filterInfo['error'] = $errMsg;
						$this->_->grid[$this->modelName]['_filtersValid'] = false;
					}
				}
			}
		}
		return $this->_->grid[$this->modelName]['_filtersValid'];
	}
	
	function _validateInteger($value) {
		return (ctype_digit($value)) ? '' : __('Enter numeric value, for ex.123', true);
	}
	
	function _validateDate($value) {
		return (strtotime($value) !== false) ? '' : __('Enter correct date, for ex. 25.12.2010', true);
	}
	
	function _initFiltersSize() {
		// для авто-ресайза контролов фильтра
		// т.к. мы не можем задать размер поля для фильтра (т.е. нельзя прописать <input type="text style="width: auto">)
		// вычисяляем макс.длину его элементов - это и есть размер для фильтра
		foreach($this->_->grid[$this->modelName]['_filters'] as $fieldID => &$filterInfo) {
			if (isset($this->_->grid[$this->modelName]['_fields'][$fieldID])) { 
				// вычисляем длину только для тех фильтров, которые будем показывать на странице
				if (!isset($filterInfo['size'])) {
					if ($filterInfo['filterType'] == 'date_picker') {
						$filterInfo['size'] = 8; // 8 символов для даты в формате дд.мм.гггг
					} else {
						$filterInfo['size'] = $this->_getMaxFieldSize($fieldID);
					}
				}
			}
		}
	}

	/**
	 * Вычисление длины поля для фильтра
	 * @param string $fieldID - ID поля
	 * @return int - макс. длина поля
	 */
	function _getMaxFieldSize($fieldID) {
		$max_size = 0;
		foreach($this->_->grid[$this->modelName]['rowset'] as $row) {
			$fieldInfo = $this->_->grid[$this->modelName]['_fields'][$fieldID];
			$value = $row[$fieldInfo['model']][$fieldInfo['field']];
			$max_size = max($max_size, mb_strlen($value));
		}
		
		if (!$max_size) { // rowset вернул пустое поле
			// в этом случае вычисляем длину поля для фильтра по заголовку
			// т.к. ширина колонки все равно будет не менее чем ширина заголовка
			$title = $this->_->grid[$this->modelName]['_fields'][$fieldID]['caption'];
			
			// заголовок может состоять из нескольких слов и при выводе расположится на несколько строк
			// берем наибольшее слово
			foreach(explode(' ', $title) as $caption_word) {
				$max_size = max($max_size, mb_strlen($caption_word));
			}
		}
		if ($max_size > 40) {
			$max_size = 40; // длинные строки - все равно обрезаем при выводе
		}
		
		// корелляция на пересчет size на width
		// $max_size-= 3;
		if ($max_size <= 0) {
			$max_size = 1; // при 0 - оно рисует стд.контрол, а не контрол с мин.шириной
		}
		return $max_size;
	}
	
	/**
	 * Инициализация order для $paginate
	 *
	 */
	function _initOrder() {
		
	}
	
	/**
	 * Инициализация переменной $paginate и получение rowset из Paginator
	 *
	 */
	function _initPagination() {
		$modelName = $this->modelName;
		
		// Set limit of shown records
		if (!isset($this->_->grid[$modelName]['limit'])) {
			$limit = (isset($this->_->params['named']['limit'])) ? $this->_->params['named']['limit'] : 10;
			$this->_->grid[$modelName]['limit'] = $limit;
		} else {
			$limit = $this->_->grid[$modelName]['limit'];
		}
		$fields = array_keys($this->_->grid[$modelName]['_fields']);
		$this->_->grid[$modelName]['_primary'] = array('model' => $this->alias, 'field' => $this->_->$modelName->primaryKey);
		$primaryKey = $this->alias.'.'.$this->_->$modelName->primaryKey;
		
		// автоматом добавляем primary key (ID) для передачи в ссылки
		if (!in_array($primaryKey, $fields)) {
			$fields[] = $primaryKey;
		}
		
		$this->_->paginate = array();
		if (isset($this->_->params['named']['page'])) {
			$this->_->paginate[$this->alias]['page'] = $this->_->params['named']['page'];
		}
		
		// Заполняем для paginate список полей
		if (isset($this->_->grid[$modelName]['hidden'])) {
			$aHidden = $this->_normalizeValues($this->alias, $this->_->grid[$modelName]['hidden']);
			$fields = array_merge($fields, $aHidden);
		}
		$this->_->paginate[$this->alias]['fields'] = $fields;
		$this->_->paginate[$this->alias]['limit'] = $limit;

		if (!isset($this->_->params['named']['sort'])) {
			// $modified = $this->_normalizeField($this->alias, 'modified');
			// установлен пре-ордер
			if (isset($this->_->grid[$modelName]['order'])) {
				$this->_->grid[$modelName]['order'] = $this->_normalizeKeys($this->alias, $this->_->grid[$modelName]['order']);
			} elseif (isset($this->_->grid[$modelName]['_fields'][$this->alias.'.modified'])) {
				// по умолчанию пытаемся сделать сортировку по modified
				$this->_->grid[$modelName]['order'] = array($this->alias.'.modified' => 'desc');
			} else {
				// делаем сортировку по первому полю
				list($field) = array_keys($this->_->grid[$modelName]['_fields']);
				$this->_->grid[$modelName]['order'] = array($field => 'asc');
			}
			
			if (isset($this->_->grid[$modelName]['order'])) {
				$this->_->paginate[$this->alias]['order'] = $this->_->grid[$modelName]['order'];
				// list($this->_->params['named']['sort']) = array_keys($this->_->paginate[$this->alias]['order']);
				// list($this->_->params['named']['direction']) = array_values($this->_->paginate[$this->alias]['order']);
			}
		}
		// fdebug($this->_->paginate, 'paginate.log');
		$aRowset = $this->_->paginate($this->alias, $this->_initConditions());
		$this->_->grid[$modelName]['rowset'] = $aRowset;
	}
	
	//  Инициализация conditions для paginate
	function _initConditions() {
		$conditions = (isset($this->_->grid[$this->modelName]['conditions'])) ? $this->_->grid[$this->modelName]['conditions'] : array();
		foreach($this->_->grid[$this->modelName]['_filters'] as $fieldID => $filterInfo) {
			if (isset($filterInfo['value']) && $filterInfo['value'] !== '' && !isset($filterInfo['error'])) {
				$condKey = $fieldID;
				$condValue = $filterInfo['value'];
				if (isset($filterInfo['conditions'])) {
					list($condKey) = array_keys($filterInfo['conditions']);
					list($condValue) = array_values($filterInfo['conditions']);
					$condValue = str_replace('{$value}', $filterInfo['value'], $condValue);
				}
				$conditions[$condKey] = $condValue;
			}
		}
		// fdebug($conditions, 'cond.log');
		return $conditions;
	}
	
	// инициализация полей для рендеринга
	// нужна только для нормализации полей
	function _initRender() {
		// $aFields = array();
		/*
		if (isset($this->_->grid[$this->modelName]['render']['fields'])) {
			$this->_->grid[$this->modelName]['render']['fields'] = $this->_normalizeKeys($this->alias, $this->_->grid[$this->modelName]['render']['fields']);
		}
		*/
	}
	
	function submit() {
		App::import('Vendor', 'json', array('file' => '../plugins/core/vendors/json.php'));
		$json = new Services_JSON();
		
		$modelName = $this->_->data['model'];
		$model = $this->_->{$modelName};
		$id = $this->_->data['id'];
		
		$aResponse = array('status' => 'ok');
		if (isset($this->_->data[$model->alias])) {
			if (isset($this->_->data['id']) && $this->_->data['id']) {
				$this->_->data[$model->alias][$model->primaryKey] = $this->_->data['id'];
			}
			if ( !(isset($model->validate) && $model->validate) ) {
				// по умолчанию проверяем на корректность даты
				$this->modelName = $modelName;
				$this->alias = $this->_->$modelName->alias;
				$this->_initFields();
				$this->_initTypes();
				foreach($this->_->data[$model->alias] as $field => &$value) {
					$fieldID = $this->_normalizeField($model->alias, $field);
					if (isset($this->_->grid[$modelName]['_fields'][$fieldID])) {
						$fieldInfo = $this->_->grid[$modelName]['_fields'][$fieldID];
						if ($fieldInfo['type'] == 'date' || $fieldInfo['type'] == 'datetime') {
							$model->validate = array(
								$field => array(
									'rule' => array('date', 'ymd'), // bug with dmy: while saving converts '23.04.2011' to '20.04.2023'
									'message' => 'Incorrect date format (dd.mm.yyyy)'
								)
							);
							if ($value) {
								$value = date('Y-m-d', strtotime($value)); // // bug with dmy: while saving converts '23.04.2011' to '20.04.2023'
							}
						}
					}
				}
				
			}
			if (!$model->saveAll($this->_->data)) {
				$aErrFields = $model->invalidFields();
				$aFields = array();
				foreach($aErrFields as $field => $message) {
					$_fieldID = 'edit_'.$model->alias.'__'.$field;
					$aFields[$_fieldID] = $message;
				}
				$aResponse = array('status' => 'error', 'fields' => $aFields);
			}
		}
		echo $json->encode($aResponse);
		exit;
	}
	
	function delete() {
		$modelName = $this->_->params['named']['model'];
		$aID = explode(',', $this->_->params['named']['id']);
		foreach($aID as $id) {
			$this->_->{$modelName}->delete($id);
		}
	}
	
	function _initReadonly() {
		if (isset($this->_->grid[$this->modelName]['readonly'])) {
			$this->_->grid[$this->modelName]['readonly'] = $this->_normalizeValues($this->alias, $this->_->grid[$this->modelName]['readonly']);
		}
		// Auto-disable to edit primary key
		$primaryKey = $this->alias.'.'.$this->_->{$this->modelName}->primaryKey;
		$this->_->grid[$this->modelName]['readonly'][] = $primaryKey;
	}
	
	function _initHiddenEdit() {
		if (isset($this->_->grid[$this->modelName]['hidden_edit'])) {
			$this->_->grid[$this->modelName]['hidden_edit'] = $this->_normalizeKeys($this->alias, $this->_->grid[$this->modelName]['hidden_edit']);
		}
		//$primaryKey = $this->alias.'.'.$this->_->{$this->modelName}->primaryKey;
		//$this->_->grid[$this->modelName]['readonly'][] = $primaryKey;
	}
	
	function _initEdit() {
		$this->_initReadonly();
		$this->_initHiddenEdit();
	}
	
	/*
	function edit($modelName, $id = 0) {
		$this->modelName = $modelName;
		$this->alias = $this->_->$modelName->alias;
		
		$this->_initFields();
		$this->_initCaptions();
		$this->_initTypes();
		$this->_initFilters();
		
		// Получить данные редактируемой записи
		$primaryKey = $this->alias.'.'.$this->_->$modelName->primaryKey;
		$this->_->grid[$modelName]['rowset'][0] = $this->_->$modelName->find('first', array('conditions' => array($primaryKey => $id)));
		
		$this->_initFiltersSize(); // должна быть здесь, т.к. использует ['rowset']
		$this->_initReadonly();
		
		$this->_->grid[$modelName]['alias'] = $this->alias;
		
		fdebug($this->_->grid, 'grid.log');
		$this->controller->set('grid', $this->_->grid);
		
		return $this->_->grid[$modelName]['rowset'];
	}
	*/
}
