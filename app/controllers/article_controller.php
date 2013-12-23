<?
class ArticleController extends SiteController {
	const PER_PAGE = 5;
	
	var $name = 'Article';
	var $components = array('articles.PCArticle', 'grid.PCGrid', 'captcha.PCCaptcha', 'comments.PCComment');
	var $helpers = array('core.PHA', 'Time', 'core.PHTime', 'articles.HtmlArticle');
	var $uses = array('articles.Article', 'media.Media', 'stats.Stat', 'seo.Seo', 'tags.Tag', 'tags.TagObject', 'SiteArticle', 'category.Category', 'comments.Comment', 'regions.Region', 'regions.RegionObject');
	
	var $Router;
	var $objectType = 'articles';
	var $aCatTitle = array(
			'news' => 'News',
			'photos' => 'Фото',
			'videos' => 'Видео'
		);
		
	var $categoryID;
		
	function beforeFilter() {
		parent::beforeFilter();
		
		// Configure::write('Config.language', 'rus');
		$this->Article = $this->SiteArticle; // что работало все, что написано для Article в самом плагине
		
		App::import('Helper', 'articles.PHTranslit');
		App::import('Helper', 'Router');
		$this->Router = new RouterHelper();
		// $this->Router->checkPageParams();
		
		$this->Router->PHTranslit = new PHTranslitHelper();
	}

	private function getCategoryID($category) {
		return str_replace('-', '', strrchr($category, '-'));
	}
	
	function beforeFilterLayout() {
		parent::beforeFilterLayout();
		$this->objectType = $this->params['object_type'];
		if (!in_array($this->objectType, array('articles', 'news', 'photos', 'videos'))) {
			$this->objectType = 'articles';
		}
		
		$this->categoryID = (isset($this->params['category']) && $this->params['category']) ? $this->getCategoryID($this->params['category']) : '';
		
		$this->currMenu = $this->objectType;
		$this->aBreadCrumbs = array('/' => 'Главная', $this->aCatTitle[$this->objectType]);
	}
	
	function beforeRenderLayout() {
		$this->set('catTitle', $this->aCatTitle[$this->objectType]);
		if ($this->objectType == 'photos') {
			$aArticles = $this->SiteArticle->find('all', array('conditions' => array('Article.object_type' => 'photos')));
			$this->set('aCategories', $aArticles);
		} elseif ($this->objectType == 'news') {
			$aRegions = $this->Region->getOptions(); //find('all', array('conditions' => array('parent_id' => null)));
			$this->set('aCategories', $aRegions);
		}else {
			$this->set('aCategories', $this->Category->find('all', array('conditions' => array('object_type' => $this->objectType))));
		}
		$this->set('objectType', $this->objectType);
		parent::beforeRenderLayout();
	}
	
	function index() {
		$title = $this->aCatTitle[$this->objectType];
		
		$conditions = array('Article.object_type' => $this->objectType, 'Article.published' => 1);
		$category = array();
		$this->pageTitle = $this->aCatTitle[$this->objectType];
		if ($this->categoryID) {
			$category = $this->Category->findById($this->categoryID);
			$title = $category['Category']['title'];
			
			$this->aBreadCrumbs = array(
				'/' => 'Главная', 
				$this->Router->getDir($this->objectType) => $this->aCatTitle[$this->objectType], 
				$title
			);
			$conditions['Article.object_id'] = $this->categoryID;
			
			$this->pageTitle = $title;
		}
		$this->grid['SiteArticle'] = array(
			'conditions' => $conditions,
			'fields' => array('Category.id', 'Category.title', 'title', 'featured', 'body', 'teaser', 'page_id', 'object_type', 'created', 'modified', 'Stat.visited', 'Stat.comments', 'Stat.photos'),
			'order' => array('Article.created' => 'desc'),
			'limit' => self::PER_PAGE
		);
		
		$aArticles = $this->PCGrid->paginate('SiteArticle');
		if ($this->objectType == 'news') {
			$aID = array();
			foreach($aArticles as $article) {
				$aID[] = $article['Article']['id'];
			}
			/*
			$aRows = $this->RegionObject->find('all', array('conditions' => array('object_type' => 'Article', 'object_id' => $aID)));
			$aArticleRegions = array();
			foreach($aRows as $row) {
				$aArticleRegions[$row['RegionObject']['object_id']] = $row;
			}
			$this->set('aArticleRegions', $aArticleRegions);
			*/
		}
		$this->set('aArticles', $aArticles);
		$this->set('title', $title);
	}
	
	function view() {
		$aArticle = $this->PCArticle->view(str_replace('.html', '', $this->params['id']));
		$articleID = $aArticle['Article']['id'];
		$aComment = $this->PCComment->post('Article', $articleID, true);
		if (isset($aComment['Comment']['id']) && $aComment['Comment']['id']) {
			$this->Stat->updateItem('Article', $articleID, 'comments');
			$this->redirect('/article/view/'.$this->params['id'].'?commentPosted=1#comments');
		}
		
		$this->Stat->updateItem('Article', $articleID, 'visited');
		$aArticle['Stat']['visited']++;
		
		if ($this->objectType == 'photos') {
			$this->aBreadCrumbs = array(
				'/' => 'Главная', 
				'/photo/' => $this->aCatTitle[$this->objectType], 
				$aArticle['Article']['title']
			);
		} elseif ($this->objectType == 'news') {
			$this->aBreadCrumbs = array(
				'/' => 'Главная', 
				'/news/' => $this->aCatTitle[$this->objectType], 
				$aArticle['Article']['title']
			);
		} else {
			$this->aBreadCrumbs = array(
				'/' => 'Главная', 
				$this->Router->getDir($this->objectType) => $this->aCatTitle[$this->objectType], 
				$this->Router->catUrl($this->objectType, $aArticle['Category']) => $aArticle['Category']['title'],
				$aArticle['Article']['title']
			);
		}
		
		unset($aArticle['Media']);
		$aArticle['Media'] = $this->Media->getMedia('Article', $aArticle['Article']['id']);
		$this->set('aArticle', $aArticle);
		
		$this->grid['Comment'] = array(
			'conditions' => array('object_type' => 'Article', 'object_id' => $articleID, 'published' => 1),
			'order' => array('created' => 'desc'),
			'limit' => 2
		);
		$aComments = $this->PCGrid->paginate('Comment');
		$this->set('aComments', $aComments);
		$this->set('commentPosted', isset($this->params['url']['commentPosted']) && $this->params['url']['commentPosted']);
		
		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title'];
		$this->data['SEO'] = $aArticle['Seo'];
		
		//$this->aTags = $this->Tag->getOptions();
		$aRelatedTags = $this->TagObject->getRelatedTags('Article', $articleID);
		$this->set('aRelatedTags', $aRelatedTags);
		if ($aRelatedTags) {
			$aRelatedArticles = $this->SiteArticle->getRelatedObjects($aRelatedTags, $this->objectType, $articleID, 3);
			$this->set('aRelatedArticles', $aRelatedArticles);
		}
		$this->set('aRegionObject', $this->RegionObject->getItem('Article', $articleID));
	}
	
	
	
}
