<?
class RegionObject extends RegionsAppModel {
	var $name = 'RegionObject';
	var $belongsTo = array(
		'RegionName' => array(
			'className' => 'regions.Region',
			'foreignKey' => 'region_id'
		),
		'SubregionName' => array(
			'className' => 'regions.Region',
			'foreignKey' => 'subregion_id'
		),
	);
	
	function getItem($object_type, $object_id) {
		return $this->find('first', array(
			'conditions' => array('object_type' => $object_type, 'object_id' => $object_id)
		));
	}
}