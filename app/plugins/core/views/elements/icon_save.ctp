<?
/**
 * Renders 'SAVE' action icon (link with image) with default settings. 
 * 
 */
	$aParams = compact('path', 'img', 'confirm', 'class', 'href', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout');
	$aParams['img'] = (isset($aParams['img'])) ? $aParams['img'] : 'save.gif';
	$aParams['title'] = (isset($aParams['title'])) ? $aParams['title'] : __('Save record', true);
	$aParams['class'] = (isset($aParams['class'])) ? ' icon_save '.$aParams['class'] : ' icon_save';
	
	$aParams['plugin'] = 'core';
?>
<?=$this->element('icon_action', $aParams)?>