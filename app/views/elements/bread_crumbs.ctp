<div style="overflow: hidden">
<?
if ($aBreadCrumbs) {
?>
<ul class="breadCrumbs clearfix">
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
?>
</div>