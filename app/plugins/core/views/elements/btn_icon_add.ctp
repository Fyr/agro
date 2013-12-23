<?
/**
 * Renders 'ADD' button with icon and default settings. 
 * 
 */
	$aParams = compact('path', 'img', 'confirm', 'class', 'href', 'id', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout');
	$aParams['title'] = (isset($aParams['title'])) ? $aParams['title'] : __('Add', true);
	
	$aParams['plugin'] = 'core';
?>
<?=$this->element('btn_icon_action', $aParams)?>