<?
class RouterHelper extends AppHelper {
	var $helpers = array('articles.PHTranslit', 'core.PHA');
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
			return $dir.$id;
		}
		
		if (in_array($aArticle['Article']['object_type'], array('news', 'offers', 'motors'))) {
			return '/'.$aArticle['Article']['object_type'].'/'.$id;
		}
		
		if ($aArticle['Article']['object_type'] == 'products') {
			if (!isset($aArticle['Subcategory']['id']) || !$aArticle['Subcategory']['id']) {
				$aArticle['Subcategory'] = array(
					'id' => 0,
					'title' => __('No subcategory', true),
					'object_id' => $aArticle['Category']['id'],
					'page_id' => NO_SUBCAT_SLUG
				);
			}
			return $this->catUrl('products', $aArticle['Subcategory']).$id;
		}
		
		if ($aArticle['Article']['object_type'] == 'brands' || $aArticle['Article']['object_type'] == 'companies') {
			return $dir.$id;
		}
		
		if ($aArticle['Article']['object_type'] == 'pages') {
			$category = 'show';
		} else {
			$category = (isset($aArticle['Category']['id']) && $aArticle['Category']['title']) ? $this->PHTranslit->convert($aArticle['Category']['title'], true).'-'.$aArticle['Category']['id'] : 'empty';
		}
		return $dir.$category.'/'.$id;
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
			'products' => 'zapchasti',
			'brands' => 'brand',
			'companies' => 'magazini-zapchastei'
		);
		$dir = (isset($aDir[$objectType])) ? $aDir[$objectType] : $objectType;
		return '/'.$dir.'/';
	}

	function transformPageParams($objectType, $url) {
		$category = (isset($this->params['category']) && $this->params['category']) ? $this->params['category'].'/' : '';
		$category.= (isset($this->params['subcategory']) && $this->params['subcategory']) ? $this->params['subcategory'].'/' : '';
		$url = str_replace(array('/article/', '/products/'), $this->getDir($objectType), $url);
		$url = str_replace('index/', $category, str_replace('page:', 'page/', $url));
		// return str_replace('page/1', '', $url);
		return preg_replace('/page\/1$/', '', $url);
	}
}
