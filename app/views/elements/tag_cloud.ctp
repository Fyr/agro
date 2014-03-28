<div id="tags" style="position:absolute;">
<?
	foreach($aTagCloud as $item) {
		$title = $item['TagcloudLink']['title'];
		$url = $item['TagcloudLink']['url'];
		$fontSize = $item['TagcloudLink']['size'];
?>
	<a href="<?=$url?>"><?=$title?></a>
<?
	}
?>
</div>