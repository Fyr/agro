<?php
class SiteController extends AppController {
	// var $uses = array('articles.Article', 'SiteArticle');
	var $uses = array('articles.Article');
	var $aFeaturedProducts, $aEvents;

	// ---------------------
	// Custom variables
	// ---------------------
	function beforeFilter() {
		//Configure::write('Config.language', 'rus');
		//Security::setHash("md5");
		//$this->Auth->allow();
		if (isset($this->params['url']) && isset($this->params['url']['url'])) {
			
			if (strpos($this->params['url']['url'], '.html') !== false) {
				$this->redirect('/'.str_replace('.html', '', $this->params['url']['url']));
				return;
			}
			if ($this->params['url']['url'] !== '/' && substr($this->params['url']['url'], -1) == '/' && !isset($this->params['url']['data'])) {
				$this->redirect('/'.substr($this->params['url']['url'], 0, -1));
				return;
			}
		}
		
		$this->beforeFilterMenu();
		$this->beforeFilterLayout();
	}

	/**
	 * Common code for setting up current menus and bottom links (for all controllers)
	 * Variables set here will be used when menus will be rendering
	 */
	function beforeFilterMenu() {
		$this->currMenu = ($this->params['controller'] == 'pages') ? $this->params['action'] : $this->params['controller'];
		$this->currLink = $this->currMenu;
	}

	function beforeRender() {
		$this->beforeRenderMenu();
		$this->beforeRenderLayout();
	}

}
class AppController extends Controller {

	// var $components = array('Auth');
	var $helpers = array('Html', 'Time', 'core.PHTime', 'core.PHA', 'media.PHMedia', 'Router', 'ArticleVars'); // , 'Mybbcode', 'Ia'

	var $errMsg = '';
	var $aErrFields = array();

	var $homePage = array('title' => 'Главная', 'img' => 'main.gif', 'href' => '/');
	var $currMenu = '', $currLink, $disableCopy = true;

	var $pageTitle;

	var $aMenu = array(
		'home' => array('href' => '/', 'title' => 'Главная'),
		'news' => array('href' => '/news', 'title' => 'Новости'),
		'products' => array('href' => '/zapchasti', 'title' => 'Запчасти'),
		'remont' => array('href' => '/pages/show/remont', 'title' => 'Ремонт'),
		'offers' => array('href' => '/offers', 'title' => 'Акции'),
		'brands' => array('href' => '/brand', 'title' => 'Бренды'),
		'motors' => array('href' => '/motors', 'title' => 'Техника'),
		'about' => array('href' => '/pages/show/about-us', 'title' => 'О нас'),
		'partner' => array('href' => '/magazini-zapchastei', 'title' => 'Дилеры'),
		'contacts' => array('href' => '/contacts', 'title' => 'Контакты')
	);

	var $aBottomLinks = array(
		'home' => array('href' => '/', 'title' => 'Главная'),
		'news' => array('href' => '/news', 'title' => 'Новости'),
		'products' => array('href' => '/zaphasti', 'title' => 'Запчасти'),
		'remont' => array('href' => '/pages/show/remont', 'title' => 'Ремонт'),
		'brands' => array('href' => '/brand', 'title' => 'Бренды'),
		'motors' => array('href' => '/motors', 'title' => 'Техника'),
		'about' => array('href' => '/pages/show/about-us', 'title' => 'О нас'),
		'partner' => array('href' => '/magazini-zapchastei', 'title' => 'Дилеры'),
		'contacts' => array('href' => '/contacts', 'title' => 'Контакты')
	);
	var $aBreadCrumbs = array();
	
	/**
	 * Common code for layout (for all controllers)
	 * Variables set here will be used when layout will be rendering
	 */
	function beforeFilterLayout() {
		// Code for layout
		$this->loadModel('articles.Article');
		$this->loadModel('SiteArticle');

		$this->Article = $this->SiteArticle;

		$this->aFeaturedProducts = $this->SiteArticle->getRandomRows(3, array('Article.object_type' => 'products', 'Article.featured' => 1, 'Article.published' => 1));
		$this->set('aFeaturedProducts', $this->aFeaturedProducts);

		$this->loadModel('SiteNews');
		$this->aEvents = $this->SiteNews->getRandomRows(1, array('Article.object_type' => 'news', 'Article.featured' => 1, 'Article.published' => 1));
		$this->set('upcomingEvent', ($this->aEvents) ? $this->aEvents[0] : false);
		
		$this->set('aFilters', array());
	}

	function beforeRenderMenu() {
		$this->pageTitle = ($this->pageTitle) ? $this->pageTitle.' - '.DOMAIN_TITLE : DOMAIN_TITLE;

		$this->set('pageTitle', $this->pageTitle);
		$this->set('currMenu', $this->currMenu);
		$this->set('currLink', $this->currLink);

		$this->set('homePage', $this->homePage);
		$this->set('isHomePage', $this->isHomePage());

		$this->errMsg = (is_array($this->errMsg)) ? implode('<br/>', $this->errMsg) : $this->errMsg;
		if ($this->errMsg) {
			$this->errMsg = '<br/>'.$this->errMsg.'<br/><br/>';
		}
		$this->set('errMsg', $this->errMsg);
		$this->set('aBreadCrumbs', $this->aBreadCrumbs);
		
		$this->set('disableCopy', !TEST_ENV && $this->disableCopy);
		if (DOMAIN_NAME == 'agromotors.by' || TEST_ENV) {
			unset($this->aMenu['home']);
		} elseif (DOMAIN_NAME == 'agromotors.ru') {
			unset($this->aMenu['motors']);
		}
		$this->set('aMenu', $this->aMenu);
		
		if (DOMAIN_NAME == 'agromotors.ru') {
			unset($this->aBottomLinks['motors']);
		}
		$this->set('aBottomLinks', $this->aBottomLinks);
	}
	
	/**
	 * Override code here for layout in specific controller
	 *
	 */
	function beforeRenderLayout() {
		$this->set('errMsg', $this->errMsg);
		$this->set('aErrFields', $this->aErrFields);
		$this->set('aBreadCrumbs', $this->aBreadCrumbs);

		// $this->Article = $this->SiteArticle;
		$this->loadModel('articles.Article');
		$this->loadModel('SiteBrand');
		$brands = $this->SiteBrand->find('all', array(
			'conditions' => array('Article.object_type' => 'brands', 'Article.published' => 1)
		));
		$this->set('aBrandTypes', $brands);
		$aBrands = array();
		foreach($brands as $article) {
			if (isset($article['Media'][0])) {
				$aBrands[] = $article;
			}
		}
		$this->set('aBrands', $aBrands);

		$aFilter = array();
		if (isset($this->params['url']['data']['filter']['Article.title']) && $this->params['url']['data']['filter']['Article.title']) {
			$aFilter['Article.title'] = $this->params['url']['data']['filter']['Article.title'];
		}
		if (isset($this->params['url']['data']['filter']['Article.object_id']) && $this->params['url']['data']['filter']['Article.object_id']) {
			$aFilter['Article.object_id'] = $this->params['url']['data']['filter']['Article.object_id'];
		}
		if (isset($this->params['url']['data']['filter']['Article.brand_id']) && $this->params['url']['data']['filter']['Article.brand_id']) {
			$aFilter['Article.brand_id'] = $this->params['url']['data']['filter']['Article.brand_id'];
		}
		if (isset($this->params['url']['data']['filter']['Tag.id']) && $this->params['url']['data']['filter']['Tag.id']) {
			$aFilter['Tag.id'] = $this->params['url']['data']['filter']['Tag.id'];
		}
		$this->set('aFilter', $aFilter);

		/*
		$this->loadModel('tags.Tag');
		$aTags = $this->Tag->find('list');
		$this->set('aTags', $aTags);
		*/
		/*
		$this->loadModel('categories.Category');
		$types = $this->Category->find('all', array(
			'conditions' => array('Category.object_type' => 'products'),
			'order' => array('object_id', 'sorting')
		));
		$aTypes = array();
		foreach($types as $type) {
			$aTypes['type_'.$type['Category']['object_id']][] = $type['Category'];
		}
		*/
		$this->loadModel('SiteCategory');
		$aTypes = $this->SiteCategory->getTypesList();
		$this->set('aTypes', $aTypes);

		// Fixes for menu titles
		$this->loadModel('SitePage');
		$aArticleTitles = $this->SitePage->find('list', array('fields' => array('page_id', 'title'), 'conditions' => array('page_id' => array('magazini-zapchastei', 'about-us', 'about-us2', 'contacts1', 'contacts2'))));
		// $this->aMenu['about']['title'] = $aArticleTitles['about-us'];
		$this->aMenu['partner']['title'] = $aArticleTitles['magazini-zapchastei'];
		$this->aBottomLinks['partner']['title'] = $aArticleTitles['magazini-zapchastei'];

		App::import('Helper', 'articles.PHTranslit');
		$this->Router->PHTranslit = new PHTranslitHelper();
		
		App::import('Helper', 'Router');
		$this->Router = new RouterHelper();

		foreach($aTypes['type_'] as $type) {
			$url = $this->Router->catUrl('products', $type);
			$this->aMenu['products']['submenu'][] = array('href' => $url, 'title' => $type['title']);
		}
		$this->set('aMenu', $this->aMenu);
		$this->set('aBottomLinks', $this->aBottomLinks);
		
		$this->loadModel('TagcloudLink');
		$this->set('aTagCloud', $this->TagcloudLink->find('all'));
		
		$this->loadModel('SlotPlace');
		$this->loadModel('Banner');
		$this->loadModel('BannerType');
		$aSlot = array();
		foreach($this->SlotPlace->getOptions() as $slot_id => $title) {
			$conditions = array('slot' => $slot_id, 'active' => 1);
			$order = 'Banner.sorting';
			$aSlot[$slot_id] = $this->Banner->find('all', compact('conditions', 'order'));
		}
		$this->set('aSlot', $aSlot);
	}

	function isHomePage() {
		return $this->params['url']['url'] == '/' || $this->params['url']['url'] == 'pages/home';
	}

}
