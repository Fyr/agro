<?
class ArticleVarsHelper extends AppHelper {
	var $helpers = array('media.PHMedia', 'Router');

	function init($aArticle, &$url, &$title, &$teaser, &$src, $size, &$featured = false, &$id = '') {
		$id = $aArticle['Article']['id'];
		$url = $this->Router->url($aArticle);
		$title = $aArticle['Article']['title'];
		$teaser = nl2br($aArticle['Article']['teaser']);
		$src = '';
		$featured = false;
		if (isset($aArticle['Media'][0])) {
			$media = $aArticle['Media'][0];
			$file = $media['file'].$media['ext'];
			if ($aArticle['Article']['object_type'] == 'products') {
				$file.= '.png';
			}
			$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], $size, $file);
			$featured = $aArticle['Article']['featured'];
		}
	}
}
