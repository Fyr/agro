<?
define('ERR_R1', __('This field should not be blank', true));

class Region extends RegionsAppModel {
	var $name = 'Region';
	// var $useTable = 'comments';
	// var $alias = 'Comment';
	
	var $validate = array(
		'name' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => ERR_R1
			)
		)
	);
	
	static $aRegions = array();
	
	function getOptions() {
		if (!self::$aRegions) {
			self::$aRegions = $this->find('list', array('conditions' => array('parent_id' => null)));
		}
		return self::$aRegions;
	}
}