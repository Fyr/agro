<?php
class PHCoreHelper extends Helper {

	var $helpers = array('Html');
	
	function css($css) {
		if (!is_array($css)) {
			$css = array($css);
		}
		foreach($css as &$_css) {
			if (strpos($_css, '/') !== false) {
				$_css = '/'.str_replace('/', '/css/', $_css);
			}
		}
		return $this->Html->css($css, null, array('inline' => false));
	}
	
	function js($js) {
		if (!is_array($js)) {
			$js = array($js);
		}
		foreach($js as &$_js) {
			if (strpos($_js, '/') !== false) {
				$_js = '/'.str_replace('/', '/js/', $_js);
			}
		}
		return $this->Html->script($js, array('inline' => false));
	}
}