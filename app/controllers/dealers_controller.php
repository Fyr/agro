<?
class DealersController extends SiteController {
	const PER_PAGE = 21;

	var $components = array('articles.PCArticle', 'grid.PCGrid');
	var $helpers = array('core.PHA', 'Time', 'core.PHTime', 'articles.HtmlArticle');
	var $uses = array('articles.Article', 'media.Media', 'seo.Seo', 'SiteCompany', 'SitePage');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Article = $this->SiteCompany;
	}

	function index() {
		// $aArticles = $this->Brand->find('all', array('conditions' => array('Brand.object_type' => 'brands', 'published' => 1), 'order' => 'sorting'));
		// $aArticles = $this->Article->find('all', array('conditions' => array('Article.object_type' => 'brands', 'published' => 1), 'order' => 'sorting'));
		// $this->set('aArticles', $aArticles);
		$this->grid['SiteCompany'] = array(
			'conditions' => array('Article.object_type' => 'companies', 'Article.published' => 1),
			'fields' => array('Article.object_type', 'Article.title', 'Article.page_id', 'Article.teaser', 'Company.phones', 'Company.address', 'Company.email', 'Company.site_url', 'Company.work_time', 'Article.featured'),
			'order' => array('Article.sorting' => 'desc', 'Article.created' => 'desc'),
			'limit' => self::PER_PAGE
		);

		$aArticles = $this->PCGrid->paginate('SiteCompany');
		$this->set('aArticles', $aArticles);
		$this->aBreadCrumbs = array('/' => 'Home', 'Dealers');
		
		$this->set('content', $this->SitePage->findByPageId('dealers'));
	}

	function view() {
		$id = (isset($this->params['id']) && $this->params['id']) ? $this->params['id'] : 0;
		$aArticle = $this->SiteCompany->findByPageId($id);
		if (!$aArticle) {
			$this->redirect('/404.html');
		}
		// $aArticle['Article'] = $aArticle['Company'];
		$this->set('aArticle', $aArticle);
		
		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title'];
		$this->data['SEO'] = $aArticle['Seo'];

		$this->aBreadCrumbs = array('/' => 'Home', '/dealer/' => 'Dealers', 'View dealer');
	}
}
