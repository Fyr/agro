<?
class AdminController extends AppController {
	var $name = 'Admin';
	var $layout = 'admin';
	var $components = array('Auth', 'articles.PCArticle', 'grid.PCGrid', 'params.PCParam');
	var $helpers = array('Text', 'Session', 'core.PHFcke', 'core.PHCore', 'core.PHA', 'grid.PHGrid');

	var $uses = array('articles.Article', 'media.Media', 'category.Category', 'tags.Tag', 'tags.TagObject', 'seo.Seo', 'SiteArticle', 'SiteProduct', 'params.Param', 'params.ParamObject', 'params.ParamValue', 'Brand', 'SiteCategory', 'tags.TagcloudLink', 'SitePage', 'SiteCompany');
	// var $helpers = array('Html'); // 'Form', 'Fck', 'Ia'

	var $aMenu = array(
		'Pages' => '/admin/pagesList/Article.object_type:pages',
		// 'articles' => '/admin/articlesList/Article.object_type:articles',
		'News' => '/admin/pagesList/Article.object_type:news',
		// 'photos' => '/admin/articlesList/Article.object_type:photos',
		// 'videos' => '/admin/articlesList/Article.object_type:videos',
		// 'comments' => '/admin/commentsList/',
		'Products' => '/admin/productsList/',
		// 'FAQs' => '/admin/faqList/'
		'Types' => '/admin/typesList/',
		// 'Categories' => '/admin/tagsList/',
		'Tech.parameters' => '/admin/paramsList/',
		'Brands' => '/admin/brandList',
		'tagcloud' => '/admin/tagcloud/',
		'Dealers' => '/admin/companiesList/',
		'Settings' => '/admin/settings',
		
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
/*
	function articlesList() {
		$objectType = $this->params['named']['Article.object_type'];
		$this->currMenu = $objectType;
		if ($objectType == 'photos') {
			$grid = array(
				'conditions' => array('Article.object_type' => $objectType),
				'fields' => array('modified', 'Article.title', 'featured', 'published'),
				'hidden' => array('body')
			);
		} else {
			$grid = array(
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
		
		$this->grid['SiteArticle'] = $grid;
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
	*/
	function pagesList() {
		$objectType = $this->params['named']['Article.object_type'];
		$this->currMenu = $objectType;
		if ($objectType == 'pages') {
			$grid = array(
				'conditions' => array('Article.object_type' => $objectType),
				'fields' => array('title', 'page_id'),
				'hidden' => array('body')
			);
		} else { // if ($objectType == 'news')
			$grid = array(
				'conditions' => array('Article.object_type' => $objectType),
				'fields' => array('title', 'page_id', 'featured', 'published'),
				'hidden' => array('body')
			);
		}/* else {
			$grid = array(
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
		*/
		$this->Article = $this->SitePage;
		$this->grid['SitePage'] = $grid;
		$this->PCGrid->paginate('SitePage');

		$aTitles = array(
			'news' => __('News', true),
			'pages' => __('Pages', true)
		);
		$this->set('pageTitle', $aTitles[$this->currMenu]);
		$this->set('objectType', $objectType);
	}
	
	function pagesEdit($id = 0) {
		$this->Article = $this->SitePage;
		$aArticle = $this->PCArticle->adminEdit(&$id, &$lSaved);
		if ($lSaved) {
			$this->redirect('/admin/pagesEdit/'.$id);
			return;
		}

		if ($id) {
			$objectType = $aArticle['Article']['object_type'];

			unset($aArticle['Media']);
			$aArticle['Media'] = $this->Media->getMedia('Page', $aArticle['Article']['id']);
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
				'news' => __('Edit "News" article', true),
				'pages' => __('Edit static page', true)
			);
		} else {
			$aTitles = array(
				'news' => __('New "News" article', true),
				'pages' => __('New static page', true)
			);
		}
		$this->set('pageTitle', $aTitles[$this->currMenu]);
		$this->set('objectType', $objectType);
	}
	

	function typesList($parentID = null) {
		$this->Article = $this->SiteCategory; // что работало все, что написано для Article в самом плагине

		if ($parentID) {
			$aType = $this->SiteCategory->findById($parentID);
			$this->set('aType', $aType);
		}
		$object_type = ($parentID) ? 'subcategory' : 'category';
		$this->grid['SiteCategory'] = array(
			'conditions' => array('Article.object_type' => $object_type, 'Article.object_id' => $parentID),
			'fields' => array('Article.id', 'Article.title', 'Article.sorting'),
			'order' => array('Article.sorting' => 'DESC'),
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
		
		if (isset($this->data['Article']) && $this->data['Article']) {
			if (isset($this->data['Article']['object_id']) && !$this->data['Article']['object_id']) {
				unset($this->data['Article']['object_id']); // object_id должно быть число или NULL
			}
		}
		$aArticle = $this->PCArticle->adminEdit(&$id, &$lSaved);

		if ($lSaved) {
			$this->redirect('/admin/typesEdit/'.$id);
		}

		if ($id) {
			unset($aArticle['Media']);
			$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
			$parentID = $aArticle['Article']['object_id'];
		} else {
			$aArticle['Article']['published'] = 1;
			$aArticle['Article']['sorting'] = 1;
			$parentID = Set::extract($this->params, 'named.object_id');
		}
		if ($parentID) {
			$aType = $this->SiteCategory->findById($parentID);
			$this->set('aType', $aType);
		}

		$this->set('data', $this->data);
		$this->set('aArticle', $aArticle);
		$this->set('parentID', $parentID);
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
		$cat_id = $aCategory['Category']['id'];
		$this->PCParam->adminBind('ProductParam', $article_id, &$lSaved);

		if ($lSaved) {
			$this->redirect('/admin/typesList/'.$cat_id);
			return;
		}

		$aParams = $this->Param->find('all', array('order' => 'title'));

		$this->set('aCategory', $aCategory);
		$this->set('aParams', $aParams);
		$this->set('aParamTypes', $this->Param->getOptions());
		$this->set('aBinded', $this->ParamObject->getBinded('ProductParam', $article_id));
	}

	function productsList() {
		$objectType = 'products';
		// $this->Brand->alias = 'Brand';
		$this->Article = $this->SiteProduct;
		$this->grid['Article'] = array(
			'conditions' => array('Article.object_type' => $objectType),
			'fields' => array('Article.id', 'Article.modified', 'Category.title', 'Subcategory.title', 'Article.title', 'Article.featured', 'Article.published', 'Article.price', 'Article.sorting'),
			'captions' => array('Category.title' => __('Type', true), 'Subcategory.title' => __('Subtype', true)),
			'order' => array('Article.id' => 'asc'),
			'filters' => array(
				'Category.title' => array(
					'filterType' => 'dropdown',
					'filterOptions' => $this->SiteCategory->getObjectOptions('category'),
					'conditions' => array('Article.cat_id' => '{$value}')
				),
				'Subcategory.title' => array(
					'filterType' => 'dropdown',
					'filterOptions' => $this->SiteCategory->getObjectOptions('subcategory'),
					'conditions' => array('Article.subcat_id' => '{$value}')
				)
			)
		);
		$this->PCGrid->paginate('Article');
	}

	function productEdit($id = 0) {
		$objectType = 'products';
		$aArticle = $this->PCArticle->adminEdit(&$id, &$lSaved);

		if ($lSaved) {
			$this->PCParam->valuesEdit('ProductParam', $id);
			$this->redirect('/admin/productEdit/'.$id);
			return;
		}
		
		$this->set('aTypes', $this->SiteCategory->getTypesList());

		// нужно для тех.параметров
		$aCategoryOptions = $this->Category->getOptions($objectType);
		$catID = 0;
		// $this->set('aCategoryOptions', $aCategoryOptions);
		
		if ($id) {
			unset($aArticle['Media']);
			$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
			$catID = $aArticle['Article']['subcat_id'];
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
	
	function companiesList() {
		$this->Article = $this->SiteCompany;
		$this->currMenu = 'companies';
		$this->grid['SiteCompany'] = array(
			'fields' => array('Company.id', 'Article.title', 'Company.phones', 'Company.address', 'Company.email', 'Company.site_url', 'Article.published'),
			'captions' => array('Company.site_url' => __('Site', true), 'Company.phones' => __('Phone', true)),
			'conditions' => array('Article.object_type' => 'companies'),
			'order' => array('id' => 'desc')
		);
		$this->PCGrid->paginate('SiteCompany');
	}

	function companiesEdit($id = 0) {
		$this->Article = $this->SiteCompany;
		$objectType = 'companies';
		$this->currMenu = $objectType;
		if (isset($this->data['Company']) && $this->data['Company']) {
			$this->data['Company']['site_url'] = str_replace('http://', '', $this->data['Company']['site_url']);
		}
		$aArticle = $this->PCArticle->adminEdit(&$id, &$lSaved);
		if ($lSaved) {
			$this->redirect('/admin/companiesEdit/'.$id);
		}

		if ($id) {
			// $aCompany = $this->SiteCompany->findById($company_id);
			unset($aArticle['Media']);
			$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
			// $aArticle['Gallery'] = $this->Media->getMedia('Company', $aArticle['Article']['id']);
		} else {
			// значения по умолчанию для статьи
			$aArticle['Article']['published'] = 1;
		}
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
	
	function tagcloud() {
		$this->grid['TagcloudLink'] = array(
			'order' => array('size' => 'desc')
		);
		$this->PCGrid->paginate('TagcloudLink');
	}

	/*
	function update() {
		$aRows = $this->Category->findAllByObject_type('products');
		foreach($aRows as $row) {
			$this->Article->save(array('id' => null, 'object_type' => 'category', 'object_id' => $row['Category']['id'], 'title' => $row['Category']['title']));
		}
		echo count($aRows).' records fixed';
		exit;
	}
	*/
	
	function update2() {
		$this->autoRender = false;
		mkdir(PATH_FILES_UPLOAD.'/page', 0755);
		$this->Media->removeImageCache();
		
		$aPages = $this->SitePage->find('all');
		$this->Media->stats['files'] = 0;
		foreach($aPages as $page) {
			$this->Media->relocateMedia('Article', $page['Article']['object_id'], 'Page', $page['Article']['id']);
			$body = str_replace('/media/router/index/article', '/media/router/index/page', $page['Article']['body']);
			$this->SitePage->save(array('id' => $page['Article']['id'], 'body' => $body));
			
			$seo = $this->Seo->getObjectItem('Article', $page['Article']['object_id']);
			$this->Seo->save(array('id' => $seo['Seo']['id'], 'object_type' => 'Page', 'object_id' => $page['Article']['id']));
		}
		echo 'Processed '.count($aPages).' news and pages, '.$this->Media->stats['files'].' media files<br>';
		
		$types = $this->Category->find('all', array(
			'conditions' => array('Category.object_type' => 'products'),
			'order' => array('id', 'sorting')
		));
		$aTypes = array();
		foreach($types as $type) {
			$conditions = array('Article.object_type' => 'category', 'Article.object_id' => $type['Category']['id']);
			$article = $this->Article->find('first', compact('conditions'));
			$type['Article'] = $article['Article'];
			$aTypes[$type['Category']['id']] = $type;
		}
		
		App::import('Helper', 'articles.PHTranslit');
		$this->PHTranslit = new PHTranslitHelper();
		
		$aCategories = $this->Article->findAllByObjectType('category');
		$cats = 0; $subcats = 0;
		foreach($aCategories as $cat) {
			$id = $cat['Article']['id'];
			$page_id = $this->PHTranslit->convert($cat['Article']['title'], true).'-'.$cat['Article']['object_id'];
			$subcat_id = $cat['Article']['object_id'];
			$cat_id = $aTypes[$subcat_id]['Category']['object_id'];
			if ($cat_id) {
				$object_type = 'subcategory';
				$object_id = $aTypes[$cat_id]['Article']['id'];
				
				$this->ParamObject->updateAll(
					array('object_id' => $id),
					array('object_id' => $subcat_id)
				); // заменить ID подкатегории на ID статьи
				$this->Article->updateAll(
					array('cat_id' => $object_id, 'subcat_id' => $id),
					array('object_id' => $subcat_id, 'object_type' => 'products')
				); // заменить ID подкатегории на ID статьи для продуктов
				$subcats++;
			} else {
				$object_type = 'category';
				$object_id = null;
				$cats++;
			}
			$this->Article->save(compact('id', 'page_id', 'object_type', 'object_id'));
		}
		echo 'Processed '.$cats.' categories, '.$subcats.' subcategories';
	}

}