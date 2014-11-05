<?
class SiteNews extends Article {
	var $name = 'SiteNews';
	var $useTable = 'pages';
	var $alias = 'Article';
	
	var $hasOne = array(
		'Seo' => array(
			'className' => 'seo.Seo',
			'foreignKey' => 'object_id',
			'conditions' => array('Seo.object_type' => 'Page'),
			'dependent' => true
		)
	);
	
	var $hasMany = array(
		'Media' => array(
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Page', 'Media.media_type' => 'image', 'Media.main' => 1),
			'dependent' => true,
			'order' => array('Media.main DESC', 'media_type')
		)
	);

}
