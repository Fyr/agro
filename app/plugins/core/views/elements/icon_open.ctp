<?
/**
 * Renders 'EDIT' action icon (link with image) with default settings. 
 * 
 */
	$aParams = compact('path', 'img', 'confirm', 'class', 'href', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout');
	$aParams['img'] = (isset($aParams['img'])) ? $aParams['img'] : 'open.gif';
	$aParams['title'] = (isset($aParams['title'])) ? $aParams['title'] : __('Open', true);
	$aParams['class'] = (isset($aParams['class'])) ? ' icon_open '.$aParams['class'] : ' icon_open';
	
	$aParams['plugin'] = 'core';
?>
<?=$this->element('icon_action', $aParams)?>