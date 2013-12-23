<?
/**
 * Renders widget "expandable block"
 * @param str $id - ID for block
 * @param str $caption - title for block
 * @param str $content - HTML-content for block
 * 
*/
	$this->Html->script('/core/js/widgets', array('inline' => false));
	$this->Html->css('/core/css/widgets', null, array('inline' => false));
?>
<div id="<?=$id?>" class="expandableBlockWidget">
	<a class="switch" href="javascript:void(0)" onclick="expandableBlockWidgetToggle('<?=$id?>');"><?=$caption?></a>
	<div class="clear"></div>
	<div class="container collapse">
		<div class="wrap">
			<?=$content?>
		</div>
	</div>
</div>