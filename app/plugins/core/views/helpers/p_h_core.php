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

	/**
	 * Get file size in a user-friendly format
	 *
	 * @param mixed $fullFileName - file size or file name
	 * @return str
	 */
	function getFileSize($fullFileName) {
		if (is_numeric($fullFileName)) {
			$bytes = $fullFileName;
		} else {
			$bytes = filesize($fullFileName);
		}
		$aSize = array('bytes', 'Kb', 'Mb', 'Gb');
		$_ret = '';
		$count = 0;
		while ($bytes > 1024 && $count < count($aSize)) {
			$bytes = $bytes / 1024;
			$count++;
		}
		return '<span class="filesize">'.round($bytes, 2).'</span> '.$aSize[$count];
	}

}