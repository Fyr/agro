<?
/**
 * Renders 'ADD' action icon (link with image) with default settings. 
 * 
 */
	$aParams = compact('path', 'img', 'confirm', 'class', 'href', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout');
	$aParams['img'] = (isset($aParams['img'])) ? $aParams['img'] : 'add.gif';
	$aParams['title'] = (isset($aParams['title'])) ? $aParams['title'] : __('Add record', true);
	$aParams['class'] = (isset($aParams['class'])) ? ' icon_add '.$aParams['class'] : ' icon_add';
	
	$aParams['plugin'] = 'core';
?>
<?=$this->element('icon_action', $aParams)?>