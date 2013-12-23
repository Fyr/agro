<?php
class PCRegionComponent extends Object {
	
	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->_ = &$controller;
	}
/*
	//called after Controller::beforeFilter()
	function startup(&$controller) {
	}

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
		$this->_->redirect($value);
	}
*/
	function _getList() {
		/*
		$aFilters = $this->_->getFilters();
		$conditions = $aFilters;
		if (isset($aFilters['Article.title'])) {
			$aFilters['Article.title'] = urldecode($aFilters['Article.title']);
			unset($conditions['Article.title']);
			$conditions['Article.title LIKE'] = str_replace('*', '%', $aFilters['Article.title']);
			// $conditions = $this->_->postConditions($conditions, array('Article.title' => 'LIKE'));
		}
		
		$aArticles = $this->_->paginate('Article', $conditions);
		*/
		/*
		foreach($aArticles as &$article) {
			$article['Article']['body'] = Sanitize::stripImages($article['Article']['body']);
		}
		*/
	  	$this->_->set('aArticles', $aArticles);
		$this->_->set('aArticleFilters', $aFilters);
		return $aArticles;
	}
	
	function _getItem($object_type, $object_id) {
		$aRegionObject = $this->_->RegionObject->getItem($object_type, $object_id);
		$this->_->set('aRegionObject', $aRegionObject);
		$this->_->set('aRegions', $this->_->Region->find('all', array('conditions' => array('parent_id' => null))));
		
		$aSubregions = array();
		if (isset($aRegionObject['RegionObject']['region_id']) && $aRegionObject['RegionObject']['region_id']) {
			$aSubregions = $this->_->Region->find('all', array('conditions' => array('parent_id' => $aRegionObject['RegionObject']['region_id'])));
		}
		$this->_->set('aSubregions', $aSubregions);
		return $aRegionObject;
	}
	
	function _getListActions($id) {
		$aAction = array(
			'icon_edit' => array('plugin' => 'core', 'href' => '/articles/acrticle/adminEdit/'.$id),
			'icon_del' => array('plugin' => 'core', 'href' => '/articles/article/adminDel/'.$id)
		);
		return $aActions;
	}

	function index() {
		return $this->_getList();
	}
	
	function adminList($aActions = false) {
		
		return $this->_getList();
	}
	
	function view($id) {
		return $this->_getItem($id);
	}
	
	function adminEdit($object_type, $object_id = 0, $lSaved = false) {
		/*
		if (isset($this->_->data['Article'])) {
			$data = $this->_->data; // array('Article' => $this->_->data['Article']);
			
			if ($id && !isset($data['Article']['id'])) {
				// auto add ID for update a record
				$data['Article']['id'] = $id;
			}
			if (isset($_POST['data_Article__body_'])) {
				$data['Article']['body'] = str_replace('\\"', '"', $_POST['data_Article__body_']);
			}
			
			$data['Article']['published'] = (isset($data['Article']['published'])) ? 1 : 0;
			$data['Article']['featured'] = (isset($data['Article']['featured'])) ? 1 : 0;
			
			if ($this->_->Article->saveAll($data)) {
				$id = $this->_->Article->id;
				$lSaved = true;
			} else {
				$this->_->aErrFields['Article'] = $this->_->Article->invalidFields();
				$this->_->set('aArticle', $data);
				return $data;
			}
		}
		*/
		return $this->_getItem($object_type, $object_id);
	}
	
	function _save($data) {
	}
}
