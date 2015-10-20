<?
/**
 * Just copied from News and changed objectType
**/
class CatalogController extends SiteController {
	const PER_PAGE = 100;

	var $components = array('articles.PCArticle', 'grid.PCGrid');
	var $helpers = array('core.PHA', 'core.PHCore', 'Time', 'core.PHTime', 'articles.HtmlArticle', 'ArticleVars');
	var $uses = array('media.Media', 'seo.Seo', 'Catalog');
	
	function index() {
		$this->grid['Catalog'] = array(
			'conditions' => array('published' => 1),
			'order' => array('Catalog.sorting' => 'asc'),
			'limit' => self::PER_PAGE
		);

		$aArticles = $this->PCGrid->paginate('Catalog');
		$this->set('aArticles', $aArticles);

		$this->aBreadCrumbs = array('/' => 'Home', 'Catalogs');
	}

	function download($id) {
		$this->autoRender = false;
		$conditions = array('media_type' => 'raw_file', 'object_type' => 'Catalog', 'main' => 1);
		$row = $this->Media->find('first', compact('conditions'));
		$file = '';
		if ($row) {
			App::import('Helper', 'media.PHMedia');
			$this->PHMedia = new PHMediaHelper();
			
			$media = $row['Media'];
			$file = $this->PHMedia->getFileName($media['object_type'], $media['id'], null, $media['file'].$media['ext']);
		}
		
		if ($file && file_exists($file)) {
			header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    // header('Content-Length: ' . filesize($file));
		    readfile($file);
		} else {
			return $this->redirect('/404');
		}
		
		
	}
}
