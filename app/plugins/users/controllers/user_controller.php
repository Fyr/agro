<?
class UserController extends UserAppController {
	var $name = 'User';
	var $components = array('PCUser');
	var $uses = array('users.User');
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
	
}
