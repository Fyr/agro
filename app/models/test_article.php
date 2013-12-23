<?
class TestArticle extends AppModel {
	var $name = 'TestArticle';
	var $alias = 'Article';
	var $useTable = 'articles';
	
	var $hasOne = array(
		'Stat' => array(
			'className' => 'stat.Stat',
			'foreignKey' => 'object_id',
			'conditions' => array('Stat.object_type' => 'Article'),
			'dependent' => true
		),
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
			'conditions' => array('Media.object_type' => 'Article'),
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
	
	function getRelatedObjects($aTags, $exceptObj, $limit = 3) {
		/*
		$aParams = array(
			'fields' => array('TagObject.object_type', 'TagObject.object_id', 'COUNT(*) as count'),
			'conditions' => array('TagObject.tag_id' => $aTags),
			'group' => array('TagObject.object_type', 'TagObject.object_id'),
			'order' => 'count DESC'
		);
		*/
		if ($exceptObj) {
			$aParams['conditions']['NOT'] = array(array('object_type' => 'Article', 'object_id' => $exceptObj['object_id']));
		}
		if ($limit) {
			$aParams['limit'] = $limit;
		}
		$_ret = $this->find('all', $aParams);
		fdebug($_ret);
		return $_ret;
	}
}
