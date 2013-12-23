<ul class="main-nav">
<?
	foreach($aMenu as $id => $menu) {
?>
	<li class="<?=(($id == $currMenu) ? 'active' : '')?>">
		<a href="<?=$menu['href']?>"><span><?=$menu['title']?></span> </a>
<?
		if (isset($menu['submenu'])) {
?>
		<ul>
<?
			foreach($menu['submenu'] as $i => $submenu) {
				$class = (($i + 1) == count($menu['submenu'])) ? ' class="last"' : '';
?>
			<li<?=$class?>><a href="<?=$submenu['href']?>"><?=$submenu['title']?></a></li>
<?
			}
?>
		</ul>
<?
		}
?>
	</li>
<?
	}
?>
</ul>
