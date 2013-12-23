<?
	$this->PHCore->js('tags/tags.js');
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td valign="top">
<?
	$count = -1;
	foreach($aTags as $id => $title) {
		$count++;
		if (!($count % 5) && $count > 0) {
?>
	</td>
	<td valign="top">
<?
		}
		$checked = (in_array($id, $aRelatedTags)) ? ' checked="checked"' : '';
?>
	<span id="tag_<?=$id?>">
		<span>
			<input class="checkbox" type="checkbox" name="tag[]" value="<?=$id?>" onclick="tag_onBind(<?=$id?>, '<?=$object_type?>', <?=$object_id?>)" <?=$checked?>/><?=$title?>
		</span>
	</span>

	<br />
<?
	}
?>
	</td>
</tr>
</table>