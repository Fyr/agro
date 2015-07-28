<?
/**
 * Just copied from News and changed objectType
**/
class MotorsController extends SiteController {
	const PER_PAGE = 100;

	// var $name = 'news';
	var $components = array('articles.PCArticle', 'grid.PCGrid');
	var $helpers = array('core.PHA', 'core.PHCore', 'Time', 'core.PHTime', 'articles.HtmlArticle', 'ArticleVars');
	var $uses = array('articles.Article', 'media.Media', 'seo.Seo', 'SitePage');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Article = $this->SitePage;
	}

	function index() {
		$this->grid['SitePage'] = array(
			'conditions' => array('Article.object_type' => 'motors', 'Article.published' => 1),
			'fields' => array('Article.created', 'Article.object_type', 'Article.title', 'Article.page_id', 'Article.teaser', 'Article.featured'),
			'order' => array('Article.sorting' => 'asc', 'Article.created' => 'desc'),
			'limit' => self::PER_PAGE
		);

		$aArticles = $this->PCGrid->paginate('SitePage');
		$this->set('aArticles', $aArticles);

		$this->aBreadCrumbs = array('/' => 'Home', 'Motors');
	}

	function view($id = '') {
		if ($id) {
			return $this->redirect('/motors/'.$id);
		}
		$id = $this->params['id'];
		$aArticle = $this->PCArticle->view($id);
		$this->set('aArticle', $aArticle);

		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title'];
		$this->data['SEO'] = $aArticle['Seo'];

		$this->aBreadCrumbs = array('/' => 'Home', '/motors/' => 'Motors', 'View');
	}
}
