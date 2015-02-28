<?
/*
	if ($aBreadCrumbs) {
		foreach($aBreadCrumbs as $url => $title) {
			if ($url) {
				echo "<a href=\"{$url}\">{$title}</a>";
			} else {
				echo "<strong>{$title}</strong>";
			}
		}
	}
*/
if ($aBreadCrumbs) {
?>

<ul class="bread">
<?
	foreach($aBreadCrumbs as $url => $title) {
		if ($url) {
?>
	<li><a href="<?=$url?>"><?__($title);?></a></li>
<?
		} else {
?>
	<li><span><?__($title)?></span></li>
<?
		}
	}
?>
</ul>
<?
}
