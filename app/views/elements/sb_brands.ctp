<ul class="nav">
<?
	foreach($aBrandTypes as $article) {
		$id = $article['Article']['id'];
		$url = '/products/index/?data[filter][Article.brand_id]='.$id;
		$title = $article['Article']['title'];
?>
	<li id="cat-nav<?=$id?>">
		<a class="" href="<?=$url?>">
			<span></span><strong><?=$title?></strong>
		</a>
<?/*

		<a class="" href="javascript:void(0)" onclick="showCategories(<?=$id?>)">
			<span></span><strong><?=$title?></strong>
		</a>

		if (isset($aTypes['type_'.$type['id']])) {
			echo '<ul class="subnav">';
			foreach($aTypes['type_'.$type['id']] as $subtype) {
?>
			<li>
				<a href="/products/?data[filter][Article.object_id]=<?=$subtype['id']?>"><?=$subtype['title']?></a>
			</li>
<?
			}
			echo '</ul>';
		}
	*/
?>
	</li>
<?
	}
?>
</ul>
