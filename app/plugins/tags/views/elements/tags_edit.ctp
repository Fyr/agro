<?
	$this->PHCore->js('tags/tags.js');
?>
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td><? __('Tag');?></td>
	<td>
		<?=$this->element('std_input', array('plugin' => 'core', 'data' => $this->data, 'field' => 'Tag.title'))?>
		<?=$this->element('icon_add', array('plugin' => 'core', 'onclick' => "tag_onAdd('".$object_type."', ".$object_id.")"))?>
	</td>
</tr>
</table>
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
			<?=$this->element('icon_del', array('plugin' => 'core', 'class' => 'fixIcon', 'onclick' => "tag_onDel(".$id.", '".$object_type."', ".$object_id.")"))?>
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