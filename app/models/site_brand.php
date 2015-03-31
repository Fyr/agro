<?
class SiteBrand extends Article {
	var $name = 'SiteBrand';
	var $useTable = 'articles';
	var $alias = 'Article';
	
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
			'className' => 'MediaProduct',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Brand', 'Media.media_type' => 'image', 'Media.main' => 1),
			'dependent' => true,
			'order' => array('Media.main DESC', 'media_type')
		)
	);

}
