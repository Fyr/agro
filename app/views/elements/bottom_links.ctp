					<ul class="add-nav">
<?

	foreach($aBottomLinks as $id => $item) {
		if ($id == $currLink) {
?>
						<li><a href="<?=$item['href']?>"><b><?=$item['title']?></b></a></li>
<?
		} else {
?>
						<li><a href="<?=$item['href']?>"><?=$item['title']?></a></li>
<?
		}
	}
?>
					</ul>
