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
		$content = $this->SitePage->findByPageId('magazini-zapchastei');
		$this->set('content', $content);
		
		$this->aBreadCrumbs = array('/' => 'Home', $content['Article']['title']);
		
		/*
		$seo = null;
		if ( !(isset($this->params['page']) && intval($this->params['page']) > 1) ) {
			$seo = $content['Seo'];
		}
		$this->data['SEO'] = $this->Seo->defaultSeo($seo,
			'Филиалы',
			'Филиалы',
			'Филиалы'
		);
		*/
		$this->data['SEO'] = $content['Seo'];
		$this->pageTitle = $this->data['SEO']['title'];
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

		$content = $this->SitePage->findByPageId('magazini-zapchastei');
		$this->aBreadCrumbs = array('/' => 'Home', '/dealer/' => $content['Article']['title'], 'View dealer');
	}
	
	function redirect_old() {
		if (isset($this->params['id']) && $this->params['id']) {
			return $this->redirect('/magazini-zapchastei/'.$this->params['id'].'.html');
		}
		return $this->redirect('/magazini-zapchastei/');
	}
}
