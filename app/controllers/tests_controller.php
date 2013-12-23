<?
class TestsController extends AppController {
	var $helpers = array();
	var $uses = array('media.Media', 'tags.TagObject', 'articles.Article', 'SiteProduct');
	var $layout = 'empty';

	function beforeFilter() {
		echo '<html>';
		echo '<head>';
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo '</head>';
		echo '<body>';
	}

	function beforeRender() {
		echo '</body>';
		echo '</html>';
		exit;
	}

	function showA($a) {
		echo '<div align="left">'.nl2br(str_replace("  ", "&nbsp;&nbsp;", htmlspecialchars(print_r($a, true)))).'</div>';
	}

	function index() {
		App::import('Helper', 'articles.PHTranslit');
		$this->PHTranslit = new PHTranslitHelper();
		
		$aArticles = $this->Article->findAllByObjectType('brands');
		$aArticles = array_merge($aArticles, $this->Article->findAllByObjectType('products'));
		$aData = array();
		$aPageID = array();
		foreach($aArticles as $article) {
			$pageID = $this->PHTranslit->convert($article['Article']['title'], true);
			if (!in_array($pageID, $aPageID)) {
				$data = array('id' => $article['Article']['id'], 'title' => $article['Article']['title'], 'page_id' => $pageID);
				$this->Article->save($data);
				$aData[] = $data;
				$aPageID[] = $pageID;
			} else {
				echo 'Incorrect page ID: '.$article['Article']['id'].' '.$article['Article']['title'].'<br>';
			}
		}
		$this->showA($aData);
		/*
		App::import('Vendor', 'path', array('file' => '../plugins/core/vendors/path.php'));
		
		$path = 'D:/Projects/mcasterlive.dev/wwwroot/app/webroot/files/article/1/181/';
		$aPath = getPathContent($path);
		
		$this->showA($aPath);
		foreach($aPath['files'] as $file) {
			echo $aPath['path'].$file.'<br/>';
			unlink($aPath['path'].$file);
		}
		rmdir($path);
		*/
		// $this->showA($this->Comment->find('all', array('fields' => array('object_type', 'object_id', 'COUNT(*) AS comment_count'), 'conditions' => array('Comment.id' => array(1, 2, 3, 4)), 'group' => array('object_type', 'object_id'))));
	}

	function server() {
		$this->showA($_SERVER);
	}

	function session() {
		// $this->showA($this->Session);
		$this->showA($_SESSION);
		//unset($_SESSION['Message']);
	}

	function cookies() {
		$this->showA($_COOKIE);
	}
}