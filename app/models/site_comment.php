<?
class SiteComment extends Comment {
	var $name = 'SiteComment';
	var $alias = 'Comment';
	/*
	var $hasOne = array(
		'Article' => array(
			'className' => 'articles.Article',
			'foreignKey' => 'object_id',
			// 'conditions' => array('Article.object_type' => 'Article'),
			'dependent' => false
		)
	);
	*/
	
	var $belongsTo = array(
		'Article' => array(
			'className' => 'articles.Article',
			'foreignKey' => 'object_id',
			'dependent' => false
		)
	);
	
}
