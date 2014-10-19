<?
class RouterHelper extends AppHelper {
	var $helpers = array('articles.PHTranslit');
	var $aCategories = array();
	
	function __construct($options = null) {
		parent::__construct($options);
		App::import('Model', 'articles.Article');
		App::import('Model', 'SiteCategory');
		$this->SiteCategory = new SiteCategory();
		$this->aCategories = array();
		foreach($this->SiteCategory->getObjectList('category') as $cat) {
			$this->aCategories[$cat['Article']['id']] = $cat['Article'];
		}
	}
	
	function url($aArticle) {
		$dir = $this->getDir($aArticle['Article']['object_type']);
		$id = ($aArticle['Article']['page_id']) ? $aArticle['Article']['page_id'] : $aArticle['Article']['id'];
		
		if ($aArticle['Article']['object_type'] == 'photos') {
			return $dir.$id.'.html';
		}
		
		if ($aArticle['Article']['object_type'] == 'news') {
			return '/news/view/'.$id;
		}
		
		if ($aArticle['Article']['object_type'] == 'products') {
			return $this->catUrl('products', $aArticle['Subcategory']).$id.'.html';
		}
		
		if ($aArticle['Article']['object_type'] == 'brands') {
			return $dir.$id.'.html';
		}
		
		if ($aArticle['Article']['object_type'] == 'pages') {
			$category = 'show';
		} else {
			$category = (isset($aArticle['Category']['id']) && $aArticle['Category']['title']) ? $this->PHTranslit->convert($aArticle['Category']['title'], true).'-'.$aArticle['Category']['id'] : 'empty';
		}
		return $dir.$category.'/'.$id.'.html';
	}
	
	function catUrl($objectType, $aCategory = null) {
		$category = (isset($aCategory['id']) && $aCategory['title']) ? $aCategory['title'] : '';
		$dir = $this->getDir($objectType);
		$cat = '';
		if ($aCategory['object_id']) { //  == 'category'
			$cat = $this->aCategories[$aCategory['object_id']]['page_id'].'/'.$aCategory['page_id'].'/';
		} else { // category
			$cat = $aCategory['page_id'].'/';
		}
		$url = $dir.$cat;
		return ($category) ? $url : $dir;
	}
	
	function getDir($objectType = 'articles') {
		$aDir = array(
			'articles' => 'article',
			'photos' => 'photo',
			'videos' => 'video',
			'products' => 'product',
			'brands' => 'brand'
		);
		$dir = (isset($aDir[$objectType])) ? $aDir[$objectType] : $objectType;
		return '/'.$dir.'/';
	}

	function transformPageParams($objectType, $url) {
		$category = (isset($this->params['category']) && $this->params['category']) ? $this->params['category'].'/' : '';
		$category.= (isset($this->params['subcategory']) && $this->params['subcategory']) ? $this->params['subcategory'].'/' : '';
		$url = str_replace(array('/article/', '/products/'), $this->getDir($objectType), $url);
		$url = str_replace('index/', $category, str_replace('page:', 'page/', $url));
		return str_replace('page/1', '', $url);
	}
}
