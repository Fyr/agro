<?
class SiteCategory extends Article {
	var $name = 'SiteCategory';
	var $alias = 'Article';

	var $hasOne = array(
		'Seo' => array(
			'className' => 'seo.Seo',
			'foreignKey' => 'object_id',
			'conditions' => array('Seo.object_type' => 'Article'),
			'dependent' => true
		)
	);

	var $belongsTo = array(
		'Category' => array(
			'className' => 'category.Category',
			'foreignKey' => 'object_id',
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
}
