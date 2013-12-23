<?
/**
 * Renders 'SAVE' button with icon and default settings. 
 * 
 */
	$aParams = compact('path', 'img', 'confirm', 'class', 'href', 'id', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout');
	$aParams['title'] = (isset($aParams['title'])) ? $aParams['title'] : __('Save', true);
	$aParams['class'] = (isset($aParams['class'])) ? ' btnIcon_save '.$aParams['class'] : ' btnIcon_save';
	
	$aParams['plugin'] = 'core';
?>
<?=$this->element('btn_icon_action', $aParams)?>