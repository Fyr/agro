<?
class NewsController extends SiteController {
	const PER_PAGE = 20;

	// var $name = 'news';
	var $components = array('articles.PCArticle', 'grid.PCGrid');
	var $helpers = array('core.PHA', 'Time', 'core.PHTime', 'articles.HtmlArticle', 'ArticleVars');
	var $uses = array('articles.Article', 'media.Media', 'seo.Seo', 'SiteNews');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Article = $this->SiteNews;
	}

	function index() {
		$this->grid['SiteNews'] = array(
			'conditions' => array('Article.object_type' => 'news', 'Article.published' => 1),
			'fields' => array('Article.created', 'Article.object_type', 'Article.title', 'Article.page_id', 'Article.teaser', 'Article.featured'),
			'order' => array('Article.created' => 'desc'),
			'limit' => self::PER_PAGE
		);

		$aArticles = $this->PCGrid->paginate('SiteNews');
		$this->set('aArticles', $aArticles);

		$this->aBreadCrumbs = array('/' => 'Home', 'News');
	}

	function view($id = '') {
		$id = $this->params['id'];
		$aArticle = $this->PCArticle->view($id);
		$this->set('aArticle', $aArticle);

		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title'];
		$this->data['SEO'] = $aArticle['Seo'];

		$this->aBreadCrumbs = array('/' => 'Home', '/news/' => 'News', 'View');
	}
}
