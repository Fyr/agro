<?
class Brand extends AppModel {
	var $name = 'Brand';
	var $alias = 'Brand';
	var $useTable = 'articles';
	
	var $hasOne = array(
		'Seo' => array(
			'className' => 'seo.Seo',
			'foreignKey' => 'object_id',
			'conditions' => array('Seo.object_type' => 'Article'),
			'dependent' => true
		)
	);
	
	var $hasMany = array(
		'Media' => array(
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Article', 'Media.media_type' => 'image', 'Media.main' => 1),
			'dependent' => true,
			'order' => array('Media.main DESC', 'media_type')
		)
	);
	
	function getOptions() {
		return $this->find('list', array('conditions' => array('object_type' => 'brands')));
	}
}
