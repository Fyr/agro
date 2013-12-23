<?
define("REGEX_EMAIL", "/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/");
define("MAX_EMAIL_ADDR_LENGTH", 50);

class AppModel extends Model {
	/*
	function saveAll(&$data) {
		foreach($data as $model => &$modelData) {
			if (!isset($modelData['modified'])) {
				$modelData['modified'] = date('Y-m-d H:i:s');
			}
		}
	}
	*/
	/*
	function loadModel($aModels) {
		if (!is_array($aModels)) {
			$aModels = array($aModels);
		}
		foreach($aModels as $model) {
			App::import('Model', $model);
			$this->{$model} = &new $model();
		}
	}
	*/
	/*
	function __construct($id = false, $table = null, $ds = null) {
		$this->beforeConstruct();
		parent::__construct($id, $table, $ds);
		$this->afterConstruct();
	}
	*/
	/**
	 * Callback function called before constructor
	 *
	 */
	//function beforeConstruct() {
	//}
	
	/**
	 * Callback function called after constructor
	 *
	 */
	//function afterConstruct() {
	//}
	
	function getIDList($aResultSet, $field = 'id', $modelName = false) {
		if (!$modelName) {
			$modelName = $this->name;
		}
		$aRet = array();
		if ($aResultSet) {
			foreach($aResultSet as $row) {
				$aRet[] = $row[$modelName][$field];
			}
		}
		return $aRet;
	}

	/**
	 * Uploads file into folder specified by $uploadDir
	 * @param str $inputName - name of "file" input
	 * @param str $uploadDir - path to upload files
	 * @param [str $newFName] - you can specify your file name
	 * @param [str $newFExt] - you can specify your file extention
	 * @return unknown
	 */
	function uploadFile($inputName, $uploadDir, $newFName = '', $newFExt = '') {
		$path = pathinfo($_FILES[$inputName]['name']);
		
		$newFExt = ($newFExt) ? $newFExt : '.'.$path['extension'];
		$newFName = ($newFName) ? $newFName : $path['filename'];
		
		$FName = $newFName.$newFExt;
		if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadDir.$FName)) {
			trigger_error('Could not upload image '.$_FILES[$inputName]['tmp_name'].' to '.$uploadDir.$FName);
			exit;
		}
		chmod($uploadDir.$FName, 0644);

		return $FName;
	}

	function getFilters($params) {
		$filtersData = (isset($params['url']['data']['filter'])) ? $params['url']['data']['filter'] : array();
		$aConditions = array();
		$aURL = array();
		foreach($filtersData as $key => $value) {
			if ($value !== '') {
				$aURL[] = 'data[filter]['.$key.']='.$value;
				
				$aConditions[$key] = $this->getFilterCondition($key, $value);
			}
		}
		return array('conditions' => $aConditions, 'url' => implode('&', $aURL));
	}
	
	function getFilterCondition($key, $value) {
		return $value;
	}
	
	function getRandomRows($count = 1, $aOptions = array()) {
		if (!isset($aOptions['conditions'])) {
			$aListOptions['conditions'] = $aOptions;
		} else {
			$aListOptions = $aOptions;
		}
		$list = $this->find('list', $aListOptions); // TODO: if number of recs > 10000, divide all row set into pages and limit row set due to page
		$aID = array_keys($list); // $this->getIDList($list, $this->primaryKey, $this->name)
		shuffle($aID);
		$aID = array_slice($aID, 0, $count);
		return $this->find('all', array('conditions' => array($this->alias.'.'.$this->primaryKey => $aID), 'order' => 'rand()'));
	}
	
	function validateRequired($aData, $aRequired) {
		$errMsg = array();
		foreach($aRequired as $field => $title) {
			if (!isset($aData[$field]) || !trim($aData[$field])) {
				$errMsg[] = "Field '{$title}' is required";
			}
		}
		return $errMsg;
	}
	
	public static function isEmailValid($email) {
		return strlen($email) < MAX_EMAIL_ADDR_LENGTH && preg_match(REGEX_EMAIL, $email);
	}
}