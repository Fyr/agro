<?
/**
 * Renders UI for uploading files (media).
 * Allowed media types are:
 * - image
 * - video
 * - audio
 * - raw file
 * @param mixed $aAllowedTypes - string or array for allowed media types. By default all media types are allowed.
 */

	// $aAllowedTypes = isset($aAllowedTypes) ? $aAllowedTypes : array('image', 'video', 'audio', 'raw_file');

?>
<h2><? __('Manage files');?></h2>
	<?=$this->element('media_input', array('plugin' => 'media'))?>
	<?=$this->element('jslist', array('plugin' => 'core', 'item' => $this->element('media_input', array('plugin' => 'media'))))?>
	<br />
	<?=$this->element('btn_icon_add', array('plugin' => 'core', 'title' => __('Add file', true), 'onclick' => 'jslist_onAdd()'))?>
	<?=$this->element('btn_icon_save', array('plugin' => 'core', 'title' => __('Upload files', true), 'onclick' => 'document.mediaForm.submit()'))?>
	<br /><br />
<?
if ($aMedia) {
?>
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<?
	foreach($aMedia as $media) {
		$selected = ($media['main']) ? 'checked="checked"' : '';
		if ($media['media_type'] == 'image') {
			$media_url = $this->PHMedia->getUrl(strtolower($media['object_type']), $media['id'], '150x', $media['file'].$media['ext']);
		} else {
			$media_url = $this->PHMedia->getRawUrl(strtolower($media['object_type']), $media['id'], $media['file'].$media['ext']);
		}
?>
<tr id="media_<?=$media['id']?>">
<?
		if ($media['media_type'] == 'image') {
?>
	<td align="center" valign="middle"><img src="<?=$this->PHMedia->getUrl($media['object_type'], $media['id'], '150x', $media['file'].$media['ext'])?>" alt="" /></td>
<?
		} else {
?>
	<td align="center" valign="middle">
		<div style="border: 2px solid #ccc; padding: 3px; width: 35px; height: 35px;">
			<img src="/media/img/icons32/<?=$media['media_type']?>.png" alt="" />
		</div>
	</td>
<?
		}
?>
	<td valign="middle">
		<span class="media_setMain_<?=$media['id']?>">
			<input class="autocompleteOff fixIcon" type="radio" name="set_main[<?=$media['media_type']?>]" value="<?=$media['id']?>" onclick="media_onSetMain(<?=$media['id']?>)" <?=$selected?> style="left: -3px; top: 2px;" /> <span>Set as main</span>
		</span>
		<br />
		<br />
		<span class="media_removable_<?=$media['id']?>">
			<?=$this->element('icon_del', array('plugin' => 'core', 'onclick' => 'media_onDel('.$media['id'].')'))?>
			<? __('Link:');?> <input type="text" name="media_file_<?=$media['id']?>" value="<?=$media_url?>" readonly="readonly" onfocus="this.select()" size="60" />
		</span>
	</td>
</tr>
<?
	}
?>
</table>
<?
}
?>
<script type="text/javascript">
function media_onDel(id) {
	input = $('.media_setMain_' + id + ' input').get(0);
	$('.media_removable_' + id).html($('.process_sample').html());
	$('.media_removable_' + id + ' .processing').show();
	$.get('/media/ajax/del/' + id, null, function(){ media_onDelComplete(id, input.checked); });
}

function media_onDelComplete(id, reload) {
	$('#media_' + id).hide();
	if (reload) {
		window.location.reload();
	}
}

function media_onSetMain(id) {
	$('.media_setMain_' + id + ' input').hide();
	$('.media_setMain_' + id + ' span').hide();
	$('.media_setMain_' + id).append($('.process_sample').html());
	$('.media_setMain_' + id + ' .processing').show();
	$.get('/media/ajax/setMain/' + id, null, function(){ media_onSetMainComplete(id); });
}

function media_onSetMainComplete(id) {
	$('.media_setMain_' + id + ' .processing').remove();
	$('.media_setMain_' + id + ' input').show();
	$('.media_setMain_' + id + ' span').show();
}
</script>
<div class="process_sample hide">
	<?=$this->element('processing', array('plugin' => 'core'))?>
</div>