<?
class Category extends CategoryAppModel {
	var $name = 'Category';
	var $useTable = 'category';
	
	function getOptions($object_type) {
		return $this->find('list', array('conditions' => array('object_type' => $object_type))); // , array('conditions' => array())
	}
}