<?
class PagesController extends SiteController {
	var $name = 'Pages';
	var $helpers = array('articles.HtmlArticle', 'ArticleVars');
	var $uses = array('articles.Article', 'SiteNews');

	function home() {
		$conditions = array('Article.object_type' => 'news', 'Article.published' => 1);
		if ($this->aEvents) {
			$conditions['Article.id <> '] = $this->aEvents[0]['Article']['id'];
		}
		$aNews = $this->Article->find('all', array(
			'conditions' => $conditions,
			'order' => array('Article.featured DESC', 'Article.created DESC'),
			'limit' => 2
		));
		$this->set('aNews', $aNews);

		$aID = array();
		foreach($this->aFeaturedProducts as $article) {
			$aID[] = $article['Article']['id'];
		}
		$aFeaturedProducts = $this->Article->find('all', array(
			'conditions' => array('Article.object_type' => 'products', 'Article.featured' => 1, 'Article.published' => 1, 'NOT' => array('Article.id' => $aID)),
			'order' => 'Article.created DESC',
			'limit' => 3
		));

		$this->set('aFeaturedProducts2', $aFeaturedProducts);

		$aID = array();
		foreach($aFeaturedProducts as $row) {
			$aID[] = $row['Article']['id'];
		}
		$aLastProducts = $this->Article->find('all', array(
			'conditions' => array('Article.object_type' => 'products', 'Article.published' => 1, 'NOT' => array('Article.id' => $aID)),
			'order' => 'Article.created DESC',
			'limit' => 8
		));
		$this->set('aLastProducts', $aLastProducts);

		$aArticle = $this->Article->findByPageId('home');
		$this->set('contentArticle', $aArticle);

		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title'];
		$this->data['SEO'] = $aArticle['Seo'];
	}
	function show($pageID) {
		$pageID = str_replace('.html', '', $pageID);
		$aArticle = $this->Article->findByPage_id($pageID);
		$this->set('aArticle', $aArticle);

		$this->aBreadCrumbs = array('/' => 'Главная', $aArticle['Article']['title']);

		if (in_array($pageID, array('dealers', 'remont', 'about-us', 'about-us2', 'contacts1', 'contacts2'))) {
			$aCurr = array(
				'dealers' => 'partner',
				'remont' => 'remont',
				'about-us' => 'aboutus',
				'about-us2' => 'aboutus',
				'contacts1' => 'contacts',
				'contacts2' => 'contacts'
			);
			$this->currMenu = $aCurr[$pageID];
			$this->currLink = $this->currMenu;
		}
		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title'];
		$this->data['SEO'] = $aArticle['Seo'];
	}

	function inprogress() {
	}

	function nonExist() {
	}
}
