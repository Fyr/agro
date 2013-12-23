<ul class="nav">
<?
	foreach($aTypes['type_'] as $type) {
?>
	<li id="cat-nav<?=$type['id']?>">
		<a class="" href="javascript:void(0)" onclick="showCategories(<?=$type['id']?>)">
			<span></span><strong><?=$type['title']?></strong>
		</a>
<?
		if (isset($aTypes['type_'.$type['id']])) {
			echo '<ul class="subnav">';
			foreach($aTypes['type_'.$type['id']] as $subtype) {
				$url = $this->Router->catUrl('products', $subtype);
?>
			<li>
				<a href="<?=$url?>"><?=$subtype['title']?></a>
			</li>
<?
			}
			echo '</ul>';
		}
?>
	</li>
<?
	}
?>
</ul>
