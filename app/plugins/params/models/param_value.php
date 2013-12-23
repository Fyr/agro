<?
class ParamValue extends ParamsAppModel {
	var $name = 'ParamValue';
	var $useTable = 'params_values';
	
	function saveParams($object_type, $object_id, $aParamID) {
		$this->deleteAll(array('object_type' => $object_type, 'object_id' => $object_id));
		foreach($aParamID as $id) {
			$this->create();
			$aData = array('object_type' => $object_type, 'object_id' => $object_id, 'param_id' => $id);
			$this->save($aData);
		}
	}
	
	function getValues($object_type, $object_id) {
		$aRows = $this->find('all', array(
			'conditions' => array('object_type' => $object_type, 'object_id' => $object_id),
			'fields' => array('param_id', 'value')
		));
		$aParams = array();
		foreach($aRows as $row) {
			$aParams[] = $row['ParamValue'];
		}
		return $aParams;
	}
	
	function getValueOptions($object_type, $object_id) {
		$sql = 'SELECT ParamValue.object_id, ParamValue.param_id, Param.title, Param.descr, Param.param_type, Param.options, ParamValue.value 
			FROM params_values AS ParamValue 
			JOIN params as Param ON Param.id = ParamValue.param_id 
			WHERE ParamValue.object_type = "'.$object_type.'" AND ParamValue.object_id = "'.$object_id.'"';
		$aRows = $this->query($sql);
		return $aRows;
	}
}
