<?
	if (!isset($div)) {
		$div = true;
	}
	
	if ($div) {
?>
<div class="item">
<?
	}
?>
	<div class="more">
		<a href="#top" class="unvisited"><? __('back to top');?></a>
	</div>
<?
	if ($div) {
?>
	</div>
<?
	}
?>