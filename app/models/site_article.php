<?
class SiteArticle extends Article {
	var $name = 'SiteArticle';
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
			'dependent' => false
		)
	);
	
	var $hasMany = array(
		'Media' => array(
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Article', 'Media.media_type' => 'image', 'Media.main' => 1),
			'dependent' => true,
			'order' => array('Media.main DESC', 'media_type')
		),
		'TagObject' => array(
			'classname' => 'tags.TagObject',
			'foreignKey' => 'object_id',
			'conditions' => array('TagObject.object_type' => 'Article'),
			'dependent' => true
		)
	);
	/*
	function getMedia($aArticle) {
		
		unset($aArticle['Media']);
		$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
	}
	*/
	function getRelatedObjects($aTags, $object_type, $exceptID, $limit = 3) {
		$sql = 'SELECT Article.id, Article.created, Article.object_type, Article.object_id, Article.title, Article.page_id, Category.id, Category.title, COUNT(*) as count 
FROM tag_objects AS TagObject
JOIN articles as Article ON Article.object_type = "'.$object_type.'" AND Article.id = TagObject.object_id
JOIN category AS Category ON Category.object_type = "'.$object_type.'" AND Category.id = Article.object_id
WHERE Article.published AND TagObject.tag_id IN ('.implode(',', $aTags).') AND NOT (TagObject.object_type = "Article" AND TagObject.object_id = '.$exceptID.')
GROUP BY TagObject.object_type, TagObject.object_id
ORDER BY count DESC, Article.created DESC
LIMIT '.$limit;
		$_ret = $this->query($sql);
		return $_ret;
	}
	
	function getLastArticles($limit = 9) {
$sql = 'SELECT Article.id, Article.created, Article.object_type, Article.object_id, Article.title, Article.page_id, Category.id, Category.title, Media.*
FROM articles as Article
JOIN category AS Category ON Category.object_type = "articles" AND Category.id = Article.object_id
JOIN media AS Media ON Media.object_type = "Article" AND Media.object_id = Article.id
WHERE Article.published AND Media.main
ORDER BY Media.id DESC
LIMIT '.$limit;
		$_ret = $this->query($sql);
		return $_ret;
	}
	
	function getLastPhotos($limit = 5) {
$sql = 'SELECT Article.id, Article.created, Article.object_type, Article.object_id, Article.title, Article.page_id, Category.id, Category.title, Media.*
FROM articles as Article
JOIN category AS Category ON Category.object_type = "photos" AND Category.id = Article.object_id
JOIN media AS Media ON Media.object_type = "Article" AND Media.object_id = Article.id
WHERE Article.published
ORDER BY Media.id DESC
LIMIT '.$limit;
		$_ret = $this->query($sql);
		return $_ret;
	}
}
