<?
/**
 * Renders 'DEL' action icon (link with image) with default settings. 
 * 
 */
	$aParams = compact('path', 'img', 'confirm', 'class', 'href', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout');
	$aParams['img'] = (isset($aParams['img'])) ? $aParams['img'] : 'del.gif';
	$aParams['title'] = (isset($aParams['title'])) ? $aParams['title'] : __('Delete record', true);
	if (!isset($aParams['onclick'])) {
		$aParams['confirm'] = (isset($aParams['confirm'])) ? $aParams['confirm'] : __('Are you sure to delete this record?', true);
	}
	$aParams['class'] = (isset($aParams['class'])) ? ' icon_del '.$aParams['class'] : ' icon_del';
	
	$aParams['plugin'] = 'core';
?>
<?=$this->element('icon_action', $aParams)?>