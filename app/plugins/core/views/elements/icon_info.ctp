<?
/**
 * Renders 'INFO' icon with tooltip. 
 * @param (str) $content - HTML content for tooltip
 * 
 */
	$this->Html->css('/core/css/tooltip', null, array('inline' => false));
	$this->Html->script('/core/js/jquery.tooltip.pack', array('inline' => false));
	$this->Html->script('/core/js/init_tooltip', array('inline' => false));
	$aParams = compact('path', 'img', 'confirm', 'class', 'href', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout');
	$aParams['class'] = (isset($aParams['class'])) ? ' icon_info '.$aParams['class'] : ' icon_info';
	
	$aParams['plugin'] = 'core';
	
	$aParams['img'] = (isset($aParams['img'])) ? $aParams['img'] : 'preview.gif';
	if (isset($aParams['title']) && trim($aParams['title'])) {
		$title = $aParams['title'];
		unset($aParams['title']);
?>
<div class="tooltip">
	<?=$this->element('icon_action', $aParams)?>
	<div class="tooltipContent" style="display: none"><?=$title?></div>
</div>
<?
	}
?>
