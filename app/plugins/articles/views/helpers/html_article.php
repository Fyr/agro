<?
App::import('Sanitize');
class HtmlArticleHelper extends AppHelper {
	var $helpers = array('Text');
	
	function stripTags($body) {
		return $this->stripImages($body);
	}
	
	function stripImages($str) {
		$str = preg_replace('/(<a[^>]*>)(<img[^>]+alt=")([^"]*)("[^>]*>)(<\/a>)/i', '$1$3$5', $str);
		$str = preg_replace('/(<img[^>]+alt=")([^"]*)("[^>]*>)/i', '$2', $str);
		$str = preg_replace('/<img[^>]*>/i', '', $str);
		return $str;
	}

	/*
	function stripAll($body) {
		// Sanitize::strip(Sanitize::stripAll($body);
	}
	*/
	function fulltext($body) {
		$body = '<p>'.str_replace(array('<br>', '<br />', '<br/>'), '</p><p>', $body).'</p>';
		return $body;
	}
	
	function brief($body, $length = 500, $options = array()) {
		$aDefault = array(
			'ending' => '...',
			'exact' => false,
			'html' => true
		);
		$options = array_merge($options, $aDefault);
		return $this->Text->truncate($this->stripTags($body), 500, $options);
	}
	
	function around($body, $keyword, $radius = 250) {
		$body = $this->Text->excerpt($this->stripTags($body), $keyword, $radius, '...');
		$body = $this->Text->highlight($body, $keyword, array('format' => '<span class="highlight">\1</span>', 'html' => false));
		return $body;
	}
	
	/*
	function around($body, $keyword) {
		$text = $this->excerpt($this->parse($body, true), $keyword, 150, '...');
		$text = $this->Text->highlight($text, $keyword);
		return str_replace("\n", '<br/>', $text);
	}
	
	function excerpt($text, $phrase, $radius = 100, $ending = "...") {
		$excerpt = $text;
		$pos = mb_strpos(mb_strtolower($excerpt), mb_strtolower($phrase));
		$endingL = '';
		if ($pos > $radius) {
			$excerpt = mb_substr($excerpt, $pos - $radius);
			$pos = $radius;
			$endingL = $ending;
		}
		if (($pos + mb_strlen($phrase) + $radius) < mb_strlen($excerpt)) {
			$excerpt = mb_substr($excerpt, 0, $pos + mb_strlen($phrase) + $radius).$ending;
		}
		return $endingL.$excerpt;
	}
	*/
}
