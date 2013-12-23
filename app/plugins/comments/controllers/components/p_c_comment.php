<?php
class PCCommentComponent extends Object {
	
	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->_ =& $controller;
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
		$this->controller->redirect($value);
	}
*/
/*
	function _getList() {
		$aFilters = $this->controller->getFilters();
		$conditions = $aFilters;
		// extra actions with filters
		$aUsers = $this->controller->paginate('User', $conditions);
	  	$this->controller->set('aUsers', $aUsers);
	  	$this->controller->set('aUserFilters', $aFilters);
	  	return $aUsers;
	}
	
	function _getItem($id) {
		$aUser = $this->_->User->findById($id);
		$this->_->set('aUser', $aUser);
		return $aUser;
	}
	*/
	function post($objectType, $objectID, $published = 0) {
		$data = array('Comment' => array());
		if (isset($this->_->data['Comment'])) {
			$data = array('Comment' => $this->_->data['Comment']);
			
			$data['Comment']['object_type'] = $objectType;
			$data['Comment']['object_id'] = $objectID;
			$data['Comment']['published'] = $published;
			
			if ($this->_->Comment->saveAll($data)) {
				$data['Comment']['id'] = $this->_->Comment->id;
				// $data['Comment']['confirm_url'] = 'http://'.DOMAIN_NAME.'/user/confirm/'.md5($data['Comment']['email'].md5($data['Comment']['password'])._SALT);
			} else {
				$this->_->aErrFields['Comment'] = $this->_->Comment->invalidFields();
				// $this->_->set('aUser', $data);
				// return $data;
			}
		}
		
		$this->_->set('aComment', $data);
		return $data;
	}
	/*
	function index() {
		return $this->_getList();
	}
	
	function adminList($aActions = false) {
		return $this->_getList();
	}
	
	function view($id) {
		return $this->_getItem($id);
	}
	
	function adminEdit($id = 0) {
		if (isset($this->controller->data['Article'])) {
			$data = array('Article' => $this->controller->data['Article']);
			
			if ($id && !isset($data['Article']['id'])) {
				// auto add ID for update a record
				$data['Article']['id'] = $id;
			}
			if (isset($_POST['data_Article__body_'])) {
				$data['Article']['body'] = str_replace('\\"', '"', $_POST['data_Article__body_']);
			}
			
			$data['Article']['published'] = (isset($data['Article']['published'])) ? 1 : 0;
			
			if ($this->controller->Article->saveAll($data)) {
				$id = $this->controller->Article->id;
			} else {
				$this->controller->aErrFields['Article'] = $this->controller->Article->invalidFields();
				$this->controller->set('aArticle', $data);
				return $data;
			}
		}
		return $this->_getItem($id);
	}
	
	function _save($data) {
	}
	*/
	
	function confirm($key = '') {
		$aUser = array();
		if ($key) {
			$aUser = $this->_->User->find('first', array('conditions' => array('MD5(CONCAT(email, password, "'._SALT.'"))' => $key))); // , 'active' => '0'
			if ($aUser) {
				$aData = array('id'  => $aUser['Comment']['id'], 'active' => 1);
				$this->_->User->save($aData);
			}
		}
		$this->_->set('aUser', $aUser);
		return $aUser;
	}
}
