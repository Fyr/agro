<?
/**
 * A db table for this model can have any fields to count stats
 *
 */
class Stat extends StatsAppModel {
	var $name = 'Stat';
	var $useTable = 'stats';

	function getItem($objectType, $objectID) {
		return $this->find('first', array('conditions' => array('object_type' => $objectType, 'object_id' => $objectID)));
	}
	
	function updateItem($objectType, $objectID, $field, $count = 1) {
		$objectID = intval($objectID);
		$row = $this->getItem($objectType, $objectID);
		$data = array();
		if ($row) {
			$data['id'] = $row['Stat']['id'];
		}
		$data['object_type'] = $objectType;
		$data['object_id'] = $objectID;
		$data[$field] = $row['Stat'][$field] + $count;
		$this->save($data);
		/*
		Если поля находятся в самой таблице:
		$sql = "UPDATE {$this->useTable} SET {$field} = {$field} + ({$count}) WHERE object_type = '{$objectType}' AND object_id = {$objectID}";
		$this->query($sql);
		*/
	}
	
	function setItem($objectType, $objectID, $field, $value) {
		$objectID = intval($objectID);
		$row = $this->getItem($objectType, $objectID);
		$data = array();
		if ($row) {
			$data['id'] = $row['Stat']['id'];
		}
		$data['object_type'] = $objectType;
		$data['object_id'] = $objectID;
		$data[$field] = $value;
		$this->save($data);
	}
	
	
}
