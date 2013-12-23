<?php
class PCParamComponent extends Object {
	
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

	function _getItem($id) {
		$aParam = $this->_->Param->findById($id);
		$this->_->set('aParam', $aParam);
		return $aParam;
	}
/*	
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
	*/
	function adminEdit($id = 0, $lSaved = false) {
		if (isset($this->_->data['Param'])) {
			
			$data = $this->_->data;
			if ($id && !isset($data['Param']['id'])) {
				// auto add ID for update a record
				$data['Param']['id'] = $id;
			}
			
			$data['Param']['required'] = (isset($data['Param']['required']) && $data['Param']['required']) ? 1 : 0;
			
			if ($this->_->Param->saveAll($data)) {
				$id = $this->_->Param->id;
				$lSaved = true;
			} else {
				$this->_->aErrFields['Param'] = $this->_->Param->invalidFields();
				$this->_->set('aParam', $data);
				return $data;
			}
		}
		$this->_->set('aParamTypes', $this->_->Param->getOptions());
		return $this->_getItem($id);
	}
	
	function adminBind($objectType, $objectID, $lSaved = false) {
		$lSaved = false;
		if (isset($this->_->data['ParamObject'])) {
			$this->_->ParamObject->bind($objectType, $objectID, $this->_->data['ParamObject']);
			$lSaved = true;
		}
	}
	
	function valuesEdit($objectType, $objectID, $lSaved = false) {
		if (isset($this->_->data['ParamValue'])) {
			$data = $this->_->data;
			foreach($data['ParamValue'] as &$row) {
				$row['object_type'] = $objectType;
				$row['object_id'] = $objectID;
			}
			$this->_->ParamValue->deleteAll(array('object_type' => $objectType, 'object_id' => $objectID));
			$this->_->ParamValue->saveAll($data['ParamValue']);
			$lSaved = true;
		}
	}
}
