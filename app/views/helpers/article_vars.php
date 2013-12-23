<?
class ArticleVarsHelper extends AppHelper {
	var $helpers = array('media.PHMedia', 'Router');
	
	function init($aArticle, &$url, &$title, &$teaser, &$src, $size, &$featured = false, &$id = '') {
		$id = $aArticle['Article']['id'];
		$url = $this->Router->url($aArticle);
		$title = $aArticle['Article']['title'];
		$teaser = $aArticle['Article']['teaser'];
		$src = '';
		$featured = false;
		if (isset($aArticle['Media'][0])) {
			$media = $aArticle['Media'][0];
			$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], $size, $media['file'].$media['ext']);
			$featured = $aArticle['Article']['featured'];
		}
	}
}
