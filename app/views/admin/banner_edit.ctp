<?
	$id = $this->PHA->read($this->data, 'Banner.id');
	$title = ($id) ? 'Редактирование баннера' : 'Новый баннер';
?>
<h2><?=$title?></h2>
<form id="articleForm" name="articleForm" action="" method="post">
<input type="hidden" name="data[Banner][id]" value="<?=$id?>" />
<table class="pad5" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td colspan="2">
		<input type="checkbox" id="Banner.active" name="data[Banner][active]" value="1" <?=($this->PHA->read($this->data, 'Banner.active')) ? 'checked="checked"' : ''?> /> Активен
	</td>
</tr>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => 'Название баннера', 'note' => 'информационно', 'class' => 'autocompleteOff', 'required' => false, 'field' => 'Banner.title', 'data' => $this->data))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => 'Слот', 'class' => 'autocompleteOff', 'required' => true, 'field' => 'Banner.slot', 'data' => $this->data, 'input' => 'dropdown', 'options' => $slotPlaceOptions))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => 'Тип баннера', 'class' => 'autocompleteOff', 'required' => true, 'field' => 'Banner.type', 'data' => $this->data, 'input' => 'dropdown', 'options' => $bannerTypeOptions))?>
<tr class="bannerOptions bannerType-<?=BannerType::HTML?>" style="display: none">
	<td>* HTML-код</td>
	<td>
		<textarea name="data[Banner][options][html]" rows="5" cols="40"><?=$this->PHA->read($this->data, 'Banner.options.html')?></textarea>
	</td>
</tr>
<tr class="bannerOptions bannerType-<?=BannerType::IMAGE?>" style="display: none">
	<td>* URL баннера</td>
	<td>
		<input type="text" name="data[Banner][options][url]" value="<?=$this->PHA->read($this->data, 'Banner.options.url')?>" style="width: 450px" />
	</td>
</tr>
<tr class="bannerOptions bannerType-<?=BannerType::IMAGE?>" style="display: none">
	<td>Alt-название</td>
	<td>
		<input type="text" name="data[Banner][options][alt]" value="<?=$this->PHA->read($this->data, 'Banner.options.alt')?>" style="width: 450px" />
	</td>
</tr>
<tr class="bannerOptions bannerType-<?=BannerType::SLIDER?>" style="display: none">
	<td>* URL баннера</td>
	<td>
		<input type="text" name="data[Banner][options][url]" value="<?=$this->PHA->read($this->data, 'Banner.options.url')?>" style="width: 450px" />
	</td>
</tr>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => 'Сортировка', 'class' => 'autocompleteOff', 'required' => false, 'field' => 'Banner.sorting', 'data' => $this->data, 'size' => 2))?>
<tr>
	<td align="center" colspan="2">
		<br>
		<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.articleForm.submit()'))?>
	</td>
</tr>

</table>
</form>
<script type="text/javascript">
function bannerTypeUpdate() {
	$('.bannerOptions').hide();
	$('.bannerType-' + $('#Banner__type').val()).show();
}

$(document).ready(function(){
	bannerTypeUpdate();
	
	$('#Banner__type').change(function(){
		bannerTypeUpdate();
	});
});
</script>
<br>
<?
	if ($id) {
?>
<form id="mediaForm" name="mediaForm" class="bannerOptions bannerType-<?=BannerType::IMAGE?> bannerType-<?=BannerType::SLIDER?>" action="/media/media/submit/" method="post" enctype="multipart/form-data">
<input type="hidden" name="data[Media][inputName]" value="files" />
<input type="hidden" name="data[Media][object_type]" value="Banner" />
<input type="hidden" name="data[Media][object_id]" value="<?=$id?>" />
<input type="hidden" name="data[Media][makeThumb]" value="1" />
<input type="hidden" name="data[backUrl]" value="/admin/bannerEdit/<?=$id?>" />
<br />
<?=$this->element('media_edit', array('plugin' => 'media', 'aMedia' => $this->PHA->read($this->data, 'Media')))?>
</form>
<?
	}
?>
