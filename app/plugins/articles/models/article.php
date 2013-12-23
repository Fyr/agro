<?
class Article extends ArticlesAppModel {
	var $name = 'Article';
	var $useTable = 'articles';
	// var $alias = 'Article';
	
	var $validate = array(
		'title' => array(
			'rule' => 'notEmpty'
		)
	);
	
}
