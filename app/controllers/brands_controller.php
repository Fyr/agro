<?
class BrandsController extends SiteController {
	const PER_PAGE = 21;

	var $components = array('articles.PCArticle', 'grid.PCGrid');
	var $helpers = array('core.PHA', 'Time', 'core.PHTime', 'articles.HtmlArticle');
	var $uses = array('articles.Article', 'media.Media', 'seo.Seo', 'Brand');

	function index() {
		// $aArticles = $this->Brand->find('all', array('conditions' => array('Brand.object_type' => 'brands', 'published' => 1), 'order' => 'sorting'));
		// $aArticles = $this->Article->find('all', array('conditions' => array('Article.object_type' => 'brands', 'published' => 1), 'order' => 'sorting'));
		// $this->set('aArticles', $aArticles);
		$this->grid['Article'] = array(
			'conditions' => array('Article.object_type' => 'brands', 'Article.published' => 1),
			'fields' => array('Article.object_type', 'Article.title', 'Article.page_id', 'Article.teaser', 'Article.featured'),
			'order' => array('Article.sorting' => 'desc', 'Article.created' => 'desc'),
			'limit' => self::PER_PAGE
		);

		$aArticles = $this->PCGrid->paginate('Article');
		$this->set('aArticles', $aArticles);
		$this->aBreadCrumbs = array('/' => 'Home', 'Brands');
	}

	function view() {
		$id = (isset($this->params['id']) && $this->params['id']) ? $this->params['id'] : 0;
		$aArticle = $this->Brand->findByPageId($id);
		if (!$aArticle) {
			$this->redirect('/404.html');
		}
		$aArticle['Article'] = $aArticle['Brand'];
		$this->set('aArticle', $aArticle);

		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title'];
		$this->data['SEO'] = $aArticle['Seo'];

		$this->aBreadCrumbs = array('/' => 'Home', '/brands/' => 'Brands', 'View brand');
	}
}
