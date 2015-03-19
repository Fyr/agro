<div id="tags" style="position:absolute; width: 200px; height: 20px; overflow: hidden;">
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