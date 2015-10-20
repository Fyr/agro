<?
	$id = $this->PHA->read($this->data, 'Catalog.id');
	$title = ($id) ? __('Edit catalog', true) : __('New catalog', true);
?>
<h2><?=$title?></h2>
<form id="articleForm" name="articleForm" action="" method="post">
<input type="hidden" name="data[Catalog][id]" value="<?=$id?>" />
<table class="pad5" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td colspan="2">
		<input type="checkbox" id="Catalog.published" name="data[Catalog][published]" value="1" <?=($this->PHA->read($this->data, 'Catalog.published')) ? 'checked="checked"' : ''?> /> Опубликован
	</td>
</tr>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => 'Название документа', 'note' => 'информационно', 'class' => 'autocompleteOff', 'required' => false, 'field' => 'Catalog.title', 'data' => $this->data, 'size' => 78))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => 'URL', 'class' => 'autocompleteOff', 'required' => true, 'field' => 'Catalog.url', 'data' => $this->data, 'size' => 78))?>
<tr>
	<td>Описание</td>
	<td>
		<textarea name="data[Catalog][descr]" rows="5" cols="60"><?=$this->PHA->read($this->data, 'Catalog.descr')?></textarea>
	</td>
</tr>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => 'Сортировка', 'class' => 'autocompleteOff', 'required' => false, 'field' => 'Catalog.sorting', 'data' => $this->data, 'size' => 2))?>
<tr>
	<td align="center" colspan="2">
		<br>
		<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.articleForm.submit()'))?>
	</td>
</tr>

</table>
</form>
<br>
<?
	if ($id) {
?>
<form id="mediaForm" name="mediaForm" class="" action="/media/media/submit/" method="post" enctype="multipart/form-data">
<input type="hidden" name="data[Media][inputName]" value="files" />
<input type="hidden" name="data[Media][object_type]" value="Catalog" />
<input type="hidden" name="data[Media][object_id]" value="<?=$id?>" />
<input type="hidden" name="data[Media][makeThumb]" value="1" />
<input type="hidden" name="data[backUrl]" value="/admin/catalogEdit/<?=$id?>" />
<br />
<?=$this->element('media_edit', array('plugin' => 'media', 'aMedia' => $this->PHA->read($this->data, 'Media')))?>
</form>
<?
	}
?>
