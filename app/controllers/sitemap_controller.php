<?
class SitemapController extends AppController {
	var $name = 'Sitemap';
	var $uses = array('articles.Article', 'SiteProduct', 'category.Category');
	// var $helpers = array('Router', 'ArticleVars');

	function xml() {
		header("Content-Type: text/xml");
		$this->layout = 'empty';
		$aArticles = $this->SiteProduct->find('all', array(
			'fields' => array('Category.id', 'Category.title', 'Category.object_id', 'Article.object_type', 'Article.object_id', 'Article.title', 'Article.page_id', 'Article.teaser', 'Article.featured'),
			'conditions' => array('Article.object_type <> ' => 'pages', 'Article.published' => 1),
			'order' => array('Article.object_type', 'Article.modified')
		));
		$this->set('aArticles', $aArticles);
		
		$aCategories = $this->Category->findAllByObjectType('products');
		$this->set('aCategories', $aCategories);
	}
}
