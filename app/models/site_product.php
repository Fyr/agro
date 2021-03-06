<?
class SiteProduct extends Article {
	var $name = 'SiteProduct';
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
			'className' => 'article.Article',
			'foreignKey' => 'cat_id',
			'dependent' => false
		),
		'Subcategory' => array(
			'className' => 'article.Article',
			'foreignKey' => 'subcat_id',
			'dependent' => false
		),
		'Brand' => array(
			'className' => 'Brand',
			'foreignKey' => 'brand_id',
			'dependent' => false
		)
	);
	var $hasMany = array(
		'Media' => array(
			'className' => 'MediaProduct',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Product', 'Media.media_type' => 'image', 'Media.main' => 1),
			'dependent' => true,
			'order' => array('Media.main DESC', 'media_type')
		)/*,
		'TagObject' => array(
			'classname' => 'tags.TagObject',
			'foreignKey' => 'object_id',
			'conditions' => array('TagObject.object_type' => 'Article'),
			'dependent' => true
		)
		*/
	);
}
