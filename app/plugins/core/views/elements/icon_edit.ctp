<?
/**
 * Renders 'EDIT' action icon (link with image) with default settings. 
 * 
 */
	$aParams = compact('path', 'img', 'confirm', 'class', 'href', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout');
	$aParams['img'] = (isset($aParams['img'])) ? $aParams['img'] : 'edit.gif';
	$aParams['title'] = (isset($aParams['title'])) ? $aParams['title'] : __('Edit record', true);
	$aParams['class'] = (isset($aParams['class'])) ? ' icon_edit '.$aParams['class'] : ' icon_edit';
	
	$aParams['plugin'] = 'core';
?>
<?=$this->element('icon_action', $aParams)?>