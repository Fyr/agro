<?
class SitemapController extends AppController {
	var $name = 'Sitemap';
	var $uses = array('articles.Article', 'SiteProduct', 'category.Category');
	// var $helpers = array('Router', 'ArticleVars');

	function xml() {
		$this->beforeRenderMenu();
		
		header("Content-Type: text/xml");
		$this->layout = 'empty';
		
		$aCategories = $this->Category->findAllByObjectType('products');
		$this->set('aCategories', $aCategories);
	}
}
