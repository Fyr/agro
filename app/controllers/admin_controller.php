<?
class AdminController extends AppController {
	var $name = 'Admin';
	var $layout = 'admin';
	var $components = array('Auth', 'articles.PCArticle', 'grid.PCGrid', 'params.PCParam');
	var $helpers = array('Text', 'Session', 'core.PHFcke', 'core.PHCore', 'core.PHA', 'grid.PHGrid');

	var $uses = array('articles.Article', 'media.Media', 'category.Category', 'tags.Tag', 'tags.TagObject', 'Brand', 'SiteArticle', 'SiteProduct', 'params.Param', 'params.ParamObject', 'params.ParamValue', 'Brand', 'SiteCategory');
	// var $helpers = array('Html'); // 'Form', 'Fck', 'Ia'

	var $aMenu = array(
		'Pages' => '/admin/articlesList/Article.object_type:pages',
		// 'articles' => '/admin/articlesList/Article.object_type:articles',
		'News' => '/admin/articlesList/Article.object_type:news',
		// 'photos' => '/admin/articlesList/Article.object_type:photos',
		// 'videos' => '/admin/articlesList/Article.object_type:videos',
		// 'comments' => '/admin/commentsList/',
		'Products' => '/admin/productsList/',
		// 'FAQs' => '/admin/faqList/'
		'Types' => '/admin/typesList/',
		'Categories' => '/admin/tagsList/',
		'Tech.parameters' => '/admin/paramsList/',
		'Brands' => '/admin/brandList',
		'Settings' => '/admin/settings'
	);
	var $currMenu = '';

	function beforeFilter() {
		Configure::write('Config.language', 'rus');

		Security::setHash("md5");
		$this->Auth->loginAction = array('controller' => 'admin', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'admin', 'action' => 'index');
		$this->Auth->logoutRedirect = '/pages/home';
		$this->Auth->userScope = array('User.group_id' => 10);

		if ($this->Auth->isAuthorized() && $this->Auth->user('group_id') != 10) {
			$this->redirect('/pages/home');
		}

		$this->Article = $this->SiteArticle; // что работало все, что написано для Article в самом плагине

		$this->beforeFilterMenu();
		$this->beforeFilterLayout();
	}


	function beforeFilterMenu() {
		$this->currMenu = $this->params['action'];
		$this->currLink = $this->params['action'];
	}

	function beforeFilterLayout() {
		// do nothing
	}

	function beforeRender() {
		$this->beforeRenderMenu();
		$this->beforeRenderLayout();
	}

	function beforeRenderLayout() {
		$this->set('errMsg', $this->errMsg);
		$this->set('aErrFields', $this->aErrFields);
	}

	function beforeRenderMenu() {
		$this->set('aMenu', $this->aMenu);
		$this->set('currMenu', $this->currMenu);
	}

	function login() {
		$this->layout = 'admin_login';
	}

	function logout() {
		$this->redirect($this->Auth->logout());
	}

	function index() {
		//$data = $this->PMCategory->children();
		/*
		$data = $this->PMCategory->generateTreeList(null, null, null, '&nbsp;&nbsp;&nbsp;');
		// debug($data);
		$categories = $this->PMCategory->generateNestedTree();
		$this->set('categories', $categories);
		*/
		// debug($categories);
	}

	function articlesList() {
		$objectType = $this->params['named']['Article.object_type'];
		$this->currMenu = $objectType;
		if ($objectType == 'photos') {
			$this->grid['SiteArticle'] = array(
				'conditions' => array('Article.object_type' => $objectType),
				'fields' => array('modified', 'Article.title', 'featured', 'published'),
				'hidden' => array('body')
			);
		} elseif ($objectType == 'pages') {
			$this->grid['SiteArticle'] = array(
				'conditions' => array('Article.object_type' => $objectType),
				'fields' => array('title', 'page_id'),
				'hidden' => array('body')
			);
		} else {
			$this->grid['SiteArticle'] = array(
				'conditions' => array('Article.object_type' => $objectType),
				'fields' => array('modified', 'Category.title', 'title', 'featured', 'published'),
				'hidden' => array('body'),
				'captions' => array('Category.title' => __('Category', true)),
				'filters' => array(
					'Category.title' => array(
						'filterType' => 'dropdown',
						'filterOptions' => $this->Category->getOptions($objectType),
						'conditions' => array('Article.object_id' => '{$value}')
					)
				)
			);
		}
		$this->PCGrid->paginate('SiteArticle');

		$aTitles = array(
			'articles' => __('Articles', true),
			'news' => __('News', true),
			'photos' => __('Photos', true),
			'videos' => __('Videos', true),
			'pages' => __('Pages', true)
		);
		$this->set('pageTitle', $aTitles[$this->currMenu]);
		$this->set('objectType', $objectType);
	}

	function articlesEdit($id = 0) {
		$aArticle = $this->PCArticle->adminEdit(&$id, &$lSaved);
		if ($lSaved) {
			$this->redirect('/admin/articlesEdit/'.$id);
		}

		if ($id) {
			$objectType = $aArticle['Article']['object_type'];
			$this->set('aTags', $this->Tag->getOptions());
			$this->set('aRelatedTags', $this->TagObject->getRelatedTags('Article', $id));

			unset($aArticle['Media']);
			$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
		} else {
			$objectType = $this->params['named']['Article.object_type'];

			// значения по умолчанию для статьи
			$aArticle['Article']['published'] = 1;
		}
		$this->set('aArticle', $aArticle);

		$this->currMenu = $objectType;
		$this->set('aCategoryOptions', $this->Category->getOptions($objectType));
		if ($id) {
			$aTitles = array(
				'articles' => __('Edit article', true),
				'news' => __('Edit "News" article', true),
				'photos' => __('Edit "Photos" article', true),
				'videos' => __('Edit "Videos" article', true),
				'pages' => __('Edit static page', true)
			);
		} else {
			$aTitles = array(
				'articles' => __('New article', true),
				'news' => __('New "News" article', true),
				'photos' => __('New "Photos" article', true),
				'videos' => __('New "Videos" article', true),
				'pages' => __('New static page', true)
			);
		}
		$this->set('pageTitle', $aTitles[$this->currMenu]);
		$this->set('objectType', $objectType);

		if ($objectType == 'photos' && $id) {
			$row = $this->Media->find('first',
				array(
					'fields' => array('object_id', 'COUNT(*) AS media_count'),
					'conditions' => array('Media.object_type' => 'Article', 'Media.object_id' => $id, 'media_type' => 'image'),
					'group' => array('object_id')
				)
			);
			$this->Stat->setItem('Article', $id, 'photos', ($row && $row[0]['media_count']) ? $row[0]['media_count'] : 0);
		}
	}

	function typesList($parentID = null) {
		$this->Article = $this->SiteCategory; // что работало все, что написано для Article в самом плагине

		if ($parentID) {
			$aType = $this->SiteCategory->findById($parentID);
			$parentID = $aType['Category']['id'];
			$this->set('aType', $aType);
		}
		$this->grid['SiteCategory'] = array(
			'conditions' => array('Article.object_type' => 'category', 'Category.object_id' => $parentID),
			'fields' => array('Category.id', 'Category.title', 'Category.sorting'),
			'order' => array('Category.id' => 'DESC'),
			// 'captions' => array('Category.title' => __('Category', true)),
			/*
			'hidden' => array('object_type'),
			'filters' => array(
				'object_type' => array(
					'filterType' => 'hidden',
					'value' => 'products'
				),
				'object_id' => array(
					'filterType' => 'hidden',
					'value' => $parentID
				)
			)
			*/
		);
		$this->PCGrid->paginate('SiteCategory');
	}

	function typesEdit($id = 0) {
		$this->Article = $this->SiteCategory; // что работало все, что написано для Article в самом плагине
		$objectType = 'category';

		if (isset($this->data['Article']) && $this->data['Article']) {
			$this->data['Category']['title'] = $this->data['Article']['title'];
			$this->data['Category']['object_type'] = 'products';
		}
		$aArticle = $this->PCArticle->adminEdit(&$id, &$lSaved);

		if ($lSaved) {
			$this->redirect('/admin/typesEdit/'.$id);
		}

		if ($id) {
			unset($aArticle['Media']);
			$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
		} else {
			$aArticle['Category']['sorting'] = 1;
			$aArticle['Article']['published'] = 1;
			$aArticle['Article']['sorting'] = 1;
		}

		$this->set('data', $this->data);
		$this->set('aArticle', $aArticle);
		$this->set('objectType', $objectType);
	}

	function tagsList() {
		$this->PCGrid->paginate('Tag');
	}

	function paramsList() {
		$aTypes = $this->Category->find('list', array('conditions' => array('object_type' => 'products')));
		$aParamTypes = $this->Param->getOptions();
		$this->grid['Param'] = array(
			'conditions' => array('object_type' => 'ProductParam'),
			'fields' => array('id', 'title', 'object_id', 'param_type', 'descr'),
			'captions' => array('object_id' => __('Category', true), 'param_type' => __('Param.type', true)),
			'filters' => array(
				'object_id' => array(
					'filterType' => 'dropdown',
					'filterOptions' => $aTypes
				),
				'param_type' => array(
					'filterType' => 'dropdown',
					'filterOptions' => $aParamTypes
				)
			)
		);
		$this->set('aParamTypes', $aParamTypes);
		$this->PCGrid->paginate('Param');

	}

	function paramEdit($id = 0) {
		$this->PCParam->adminEdit(&$id, &$lSaved);
		if ($lSaved) {
			$this->redirect('/admin/paramsList/');
		}
	}

	function assocParams($article_id = 0) {
		$aCategory = $this->SiteCategory->findById($article_id);
		$id = $aCategory['Category']['id'];
		$this->PCParam->adminBind('ProductParam', $id, &$lSaved);

		if ($lSaved) {
			$this->redirect('/admin/typesList/'.$aCategory['Category']['object_id']);
		}

		$aParams = $this->Param->find('all', array('order' => 'title'));

		$this->set('aCategory', $aCategory);
		$this->set('aParams', $aParams);
		$this->set('aParamTypes', $this->Param->getOptions());
		$this->set('aBinded', $this->ParamObject->getBinded('ProductParam', $id));
	}

	function productsList() {
		$objectType = 'products';
		// $this->Brand->alias = 'Brand';
		// $this->Article = $this->SiteProduct;
		$this->grid['SiteProduct'] = array(
			'conditions' => array('Article.object_type' => $objectType),
			'fields' => array('Article.modified', 'Category.title', 'Article.title', 'Article.featured', 'Article.published', 'Article.sorting'),
			'captions' => array('Category.title' => __('Type', true)),
			'order' => array('Article.sorting' => 'asc'),
			'filters' => array(
				'Category.title' => array(
					'filterType' => 'dropdown',
					'filterOptions' => $this->Category->getOptions($objectType),
					'conditions' => array('Article.object_id' => '{$value}')
				)
			)
		);
		$a = $this->PCGrid->paginate('SiteProduct');
	}

	function productEdit($id = 0) {
		$objectType = 'products';
		$aArticle = $this->PCArticle->adminEdit(&$id, &$lSaved);

		if ($lSaved) {
			$this->PCParam->valuesEdit('ProductParam', $id);
			$this->redirect('/admin/productEdit/'.$id);
		}

		$types = $this->Category->find('all', array(
			'conditions' => array('Category.object_type' => 'products'),
			'order' => array('Category.object_id', 'Category.sorting')
		));
		$aTypes = array();
		foreach($types as $type) {
			$aTypes['type_'.$type['Category']['object_id']][] = $type['Category'];
		}
		$this->set('aTypes', $aTypes);

		$aCategoryOptions = $this->Category->getOptions($objectType);
		$catID = 0;
		$this->set('aCategoryOptions', $aCategoryOptions);

		if ($id) {
			unset($aArticle['Media']);
			$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
			$catID = $aArticle['Category']['id'];
		} else {
			$aArticle['Article']['published'] = 1;
			list($catID) = array_keys($aCategoryOptions);
		}

		if (!isset($this->data['ParamValue'])) {
			$this->data['ParamValue'] = $this->ParamValue->getValues('ProductParam', $id);
		}

		$this->set('data', $this->data);
		$this->set('aArticle', $aArticle);
		$this->set('objectType', $objectType);

		$aParams = $this->Param->getParams($this->ParamObject->getBinded('ProductParam', $catID));
		$this->set('aParams', $aParams);

		$this->set('aTags', $this->Tag->getOptions());
		$this->set('aRelatedTags', $this->TagObject->getRelatedTags('Article', $id));

		$aBrandOptions = $this->Brand->getOptions();
		$this->set('aBrandOptions', $aBrandOptions);
	}

	function brandList() {
		$objectType = 'brands';
		$this->grid['SiteArticle'] = array(
			'conditions' => array('Article.object_type' => $objectType),
			'fields' => array('modified', 'title', 'teaser', 'sorting'),
			'order' => array('sorting' => 'asc')
		);
		$this->PCGrid->paginate('SiteArticle');
	}

	function brandEdit($id = 0) {
		$objectType = 'brands';
		$aArticle = $this->PCArticle->adminEdit(&$id, &$lSaved);

		if ($lSaved) {
			// $this->PCParam->valuesEdit('ProductParam', $id);
			// $this->redirect('/admin/productEdit/'.$id);
		}

		if ($id) {
			unset($aArticle['Media']);
			$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
		} else {
			$aArticle['Article']['published'] = 1;
			$aArticle['Article']['sorting'] = 1;
		}

		$this->set('data', $this->data);
		$this->set('aArticle', $aArticle);
		$this->set('objectType', $objectType);
	}

	function settings() {
		if (isset($this->data)) {

			$php = "<?\r\n";
			foreach($this->data['Settings'] as $key => $val) {
				$php.= "define('{$key}', '{$val}');\r\n";
			}
			file_put_contents(ROOT.DS.'app'.DS.'config'.DS.'extra.php', $php);
			$this->redirect('/admin/settings?success=1');
			return;
		}
		$data = array(
			array('caption' => __('Price prefix', true), 'field' => 'Settings.PU_', 'value' => PU_),
			array('caption' => __('Price postfix', true), 'field' => 'Settings._PU', 'value' => _PU),
			array('caption' => __('Price2 prefix', true), 'field' => 'Settings.PU2_', 'value' => PU2_),
			array('caption' => __('Price2 postfix', true), 'field' => 'Settings._PU2', 'value' => _PU2),
			array('caption' => __('RUR course', true), 'field' => 'Settings.RUR_COURSE', 'value' => RUR_COURSE),
			array('caption' => __('PU_DIV', true), 'field' => 'Settings.PU_DIV', 'value' => PU_DIV)
		);
		$this->set('data', $data);

		$data2 = array(
			array('caption' => __('Phone', true), 'field' => 'Settings.PHONE', 'value' => PHONE),
			array('caption' => __('Phone', true).' 2', 'field' => 'Settings.PHONE2', 'value' => PHONE2),
			array('caption' => __('Address', true), 'field' => 'Settings.ADDRESS', 'value' => ADDRESS)
		);
		$this->set('data2', $data2);
	}

	function utils() {

	}

	function removeImageCache() {
		$this->set('stats', $this->Media->removeImageCache());
	}

	function update() {
		$aRows = $this->Category->findAllByObject_type('products');
		foreach($aRows as $row) {
			$this->Article->save(array('id' => null, 'object_type' => 'category', 'object_id' => $row['Category']['id'], 'title' => $row['Category']['title']));
		}
		echo count($aRows).' records fixed';
		exit;
	}

}