<?
class ParamObject extends ParamsAppModel {
	var $name = 'ParamObject';
	var $useTable = 'params_objects';
	
	function bind($object_type, $object_id, $aParamID) {
		$this->deleteAll(array('object_type' => $object_type, 'object_id' => $object_id));
		foreach($aParamID as $id) {
			$this->create();
			$aData = array('object_type' => $object_type, 'object_id' => $object_id, 'param_id' => $id);
			$this->save($aData);
		}
	}
	
	function getBinded($object_type, $object_id) {
		$aRows = $this->find('all', array(
			'conditions' => array('object_type' => $object_type, 'object_id' => $object_id)
		));
		$aParams = array();
		foreach($aRows as $row) {
			$aParams[] = $row['ParamObject']['param_id'];
		}
		return $aParams;
	}
	
}
