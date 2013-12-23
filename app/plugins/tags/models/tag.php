<?
class Tag extends TagsAppModel {
	var $name = 'Tag';
	var $useTable = 'tags';
	
	var $validate = array(
		'title' => array(
			'rule' => 'notEmpty'
		)
	);
	
	static $aTags = array();
	
	function getOptions() {
		if (!self::$aTags) {
			self::$aTags = $this->find('list', array('order' => 'title'));
		}
		return self::$aTags;
	}
}
