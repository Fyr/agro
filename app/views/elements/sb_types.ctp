<ul class="catalog" id="catalog">
<?
	foreach($aTypes['type_'] as $type) {
?>
	<li id="cat-nav<?=$type['id']?>">
        <a href="javascript: void(0)" class="firstLevel"><span class="icon arrow"></span><?=$type['title']?></a>
<?
		if (isset($aTypes['type_'.$type['id']])) {
?>
		<ul style="display: none">
<?
			foreach($aTypes['type_'.$type['id']] as $subtype) {
				$url = $this->Router->catUrl('products', $subtype);
?>
            <li><a href="<?=$url?>"><span class="icon smallArrow"></span> <?=$subtype['title']?></a></li>
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