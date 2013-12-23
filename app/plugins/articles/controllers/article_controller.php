<?
class ArticleController extends ArticlesAppController {
	var $name = 'Article';
	var $components = array('PCArticle');
	var $uses = array('articles.Article');
	var $paginate = array(
		'Article' => array(
			'limit' => 10,
			'order' => array(
				'Article.modified' => 'asc'
			)
		)
	);
	
	function beforeFilter() {
		
		
	}
	
	function _install() {
		
	}
	
	
	function index() {
		$this->PCArticle->index();
	}
	
	
	function adminList() {
		$this->PCArticle->adminList();
	}
	
	function create($objectType) {
		
	}
	
	function adminEdit($id) {
		$this->PCArticle->adminEdit($id);
	}
	
	function del($id) {
		
	}
	
	function view($id) {
		$this->PCArticle->view($id);
	}
	
/*
	function articles($cat = 'articles') {
		$aFilters = $this->getArticleFilters($cat);
		$this->set('cat', $cat);
		$this->set('aArticles', $this->paginate('Article', $aFilters['conditions']));
		$this->set('aSectionFilters', $this->Article->getSections($cat));
		$this->set('aAuthorFilters', $this->Article->getAuthors($cat));
		$this->set('filterURL', $aFilters['url']);

		$this->currMenu = $cat;
		$this->currLink = $cat;
	}

	function editArticle($id = 0) {
		$data = array();
		$images = array();

		if (isset($this->data['save'])) {
			if (!$id) {
				$this->data['Article']['category'] = $this->params['url']['cat'];
			}
			$this->data['Article']['featured'] = (isset($_POST['featured'])) ? '1' : '0';
			$this->Article->save($this->data);
			$id = $this->Article->id;
			$article = $this->Article->findById($id);
			$cat = ($article['Article']['category'] == 'news') ? '/news' : '';
			$this->redirect('/admin/articles'.$cat);
		}

		if ($id && isset($this->data['addImage'])) {
			$this->Media->save($this->data);
			$this->redirect('/admin/editArticle/'.$id);
		}

		if ($id) {
			$data = $this->Article->findById($id);
			$images = $data['Media'];
		}
		$this->set('id', $id);
		$this->set('data', $data);
		$this->set('images', $images);
	}

	function delArticle($id) {
		$article = $this->Article->findById($id);
		$cat = ($article['Article']['category'] == 'news') ? '/news' : '';

		$this->Article->del($id);

		$this->redirect('/admin/articles'.$cat);
		exit;
	}

*/
}
