<?
	$this->Html->script('/articles/js/translit_utf', array('inline' => false));

	$id = $this->PHA->read($aArticle, 'Article.id');
	$page_id = $this->PHA->read($aArticle, 'Article.page_id');
	$seo_block = $this->element('admin_edit', array('plugin' => 'seo', 'data' => $aArticle, 'object_type' => 'Article'));
?>
<h2><?=($id) ? __('Edit product') : __('New product')?></h2>
<?
	if ($id) {
?>
<div align="right" style="width: 550px">
	<a href="/products/view/<?=$aArticle['Article']['id']?>" target="_blank" title="<? __('View this article on site in a new tab');?>"><? __('View article');?></a>
</div>
<?
	}
?>
<div class="errMsg"><?=$errMsg?></div>
<form id="articleForm" name="articleForm" action="" method="post">
<input type="hidden" name="data[Article][object_type]" value="<?=$objectType?>" />
<table class="pad5" cellspacing="0" cellpadding="0" border="0">
<? // $this->element('std_input', array('plugin' => 'core', 'class' => 'autocompleteOff', 'caption' => __('Type', true), 'field' => 'Article.object_id', 'data' => $aArticle, 'required' => true, 'input' => 'dropdown', 'options' => $aCategoryOptions, 'onchange' => 'type_onChange($(this).val())'))?>
<tr>
	<td>* <? __('Subtype');?></td>
	<td>
<select onchange="type_onChange($(this).val())" class="autocompleteOff" name="data[Article][object_id]" id="Article__object_id" autocomplete="off">
<?=$this->element('choose_type', array('aTypes' => $aTypes, 'selected' => $this->PHA->read($aArticle, 'Article.object_id')));?>
</select>
	</td>
</tr>

<?=$this->element('std_input', array('plugin' => 'core', 'class' => 'autocompleteOff', 'caption' => __('Brand', true), 'field' => 'Article.brand_id', 'data' => $aArticle, 'required' => true, 'input' => 'dropdown', 'options' => $aBrandOptions))?>
</table>
<?
	echo $this->element('wgt_exp_block', array('plugin' => 'core', 'id' => 'seo', 'caption' => 'SEO', 'content' => $seo_block));
	
	$tags_block = $this->element('tags_bind', array('plugin' => 'tags', 'aTags' => $aTags, 'object_type' => 'Article', 'object_id' => $id, 'aRelatedTags' => $aRelatedTags));
	echo $this->element('wgt_exp_block', array('plugin' => 'core', 'id' => 'tags', 'caption' => __('Categories', true), 'content' => $tags_block));

	$params_block = $this->element('params_edit', array('plugin' => 'params', 'aParams' => $aParams, 'data' => $data));
	echo $this->element('wgt_exp_block', array('plugin' => 'core', 'id' => 'params', 'caption' => __('Tech.parameters', true), 'content' => $params_block));
	// echo '<br />';
?>
<br />
<table class="pad5" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td colspan="2">
		<input type="checkbox" id="Article.published" name="data[Article][published]" value="1" <?=($this->PHA->read($aArticle, 'Article.published')) ? 'checked="checked"' : ''?> /> <? __('Published');?>
		<input type="checkbox" id="Article.featured" name="data[Article][featured]" value="1" <?=($this->PHA->read($aArticle, 'Article.featured')) ? 'checked="checked"' : ''?> /> <? __('Featured');?>
		<input type="checkbox" id="Article.active" name="data[Article][active]" value="1" <?=($this->PHA->read($aArticle, 'Article.active')) ? 'checked="checked"' : ''?> /> <? __('Active');?>
	</td>
</tr>
<?//$this->element('std_input', array('plugin' => 'core', 'caption' => __('Title', true), 'class' => 'autocompleteOff', 'required' => true, 'field' => 'Article.title', 'data' => $aArticle, 'size' => 78))?>
<?//$this->element('std_input', array('plugin' => 'core', 'caption' => __('Page ID', true), 'class' => 'autocompleteOff', 'field' => 'Article.page_id', 'data' => $aArticle, 'size' => 78))?>
<tr>
	<td><? __('Title');?></td>
	<td>
		<input type="text" class="autocompleteOff" id="Article__title" name="data[Article][title]" value="<?=$this->PHA->read($aArticle, 'Article.title')?>" size="68" onkeyup="article_onChangeTitle()"/>
<?
	if (isset($aErrFields['Article']['title'])) {
?>
		<span class="errNote"><? __($aErrFields['Article']['title']);?></span>
<?
	}
?>
	</td>
</tr>
<tr>
	<td><? __('Page ID');?></td>
	<td>
		<input type="text" class="autocompleteOff" id="Article__page_id" name="data[Article][page_id]" value="<?=$this->PHA->read($aArticle, 'Article.page_id')?>" size="68" onchange="article_onChangePageID()"/>
<?
	if (isset($aErrFields['Article']['page_id'])) {
?>
		<span class="errNote"><? __($aErrFields['Article']['page_id']);?></span>
<?
	}
?>
</tr>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Sorting order', true), 'class' => 'autocompleteOff', 'required' => false, 'field' => 'Article.sorting', 'data' => $aArticle, 'size' => 2))?>
<?//$this->element('std_input', array('plugin' => 'core', 'caption' => __('Price', true).', '._PU, 'class' => 'autocompleteOff', 'required' => false, 'field' => 'Article.price', 'data' => $aArticle, 'size' => 5))?>
<tr>
	<td>
		<? __('Price');?><br>
	</td>
	<td>
		<input type="text" value="<?=$this->PHA->read($aArticle, 'Article.price')?>" class="autocompleteOff" size="5" name="data[Article][price]" id="Article__price"><?=_PU?>
	</td>
</tr>
<tr>
	<td colspan="2">
		<? __('Teaser'); ?><br />
		<textarea name="data[Article][teaser]" rows="1" cols="40" style="width: 550px; height: 100px"><?=$this->PHA->read($aArticle, 'Article.teaser')?></textarea>
	</td>
</tr>
<tr>
	<td colspan="2">
		<? __('Description'); ?><br />
		<?=$this->PHFcke->textarea("data_Article__body_", $this->PHA->read($aArticle, 'Article.body'), 'Small')?>
	</td>
</tr>
<tr>
	<td align="center" colspan="2">
		<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.articleForm.submit()'))?>
		<?//$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.articleForm.submit()', 'title' => __('Save & View list', true)))?>
	</td>
</tr>
</table>
</form>
<div class="load hide">
	<?=$this->element('processing', array('plugin' => 'core', 'show' => true))?>
</div>
<?
	if ($id) {
?>
<form id="mediaForm" name="mediaForm" action="/media/media/submit/" method="post" enctype="multipart/form-data">
<input type="hidden" name="data[Media][inputName]" value="files" />
<input type="hidden" name="data[Media][object_type]" value="Article" />
<input type="hidden" name="data[Media][object_id]" value="<?=$this->PHA->read($aArticle, 'Article.id')?>" />
<input type="hidden" name="data[Media][makeThumb]" value="1" />
<input type="hidden" name="data[backUrl]" value="/admin/productEdit/<?=$id?>" />
<br />
<?=$this->element('media_edit', array('plugin' => 'media', 'aMedia' => $aArticle['Media']))?>
</form>
<?
	}
?>
<script type="text/javascript">
function type_onChange(typeID) {
	var id = <?=($id) ? $id : '0'?>;
	$('#params .container .wrap').html($('.load').html());
	$('#params .container .wrap').load('/adminAjax/getTechParams/' + typeID + '/' + id);
}

var pageID_EditMode = <?=(($this->PHA->read($aArticle, 'Article.page_id'))) ? 'true' : 'false'?>;
function article_onChangeTitle() {
	if (!pageID_EditMode) {
		$('#Article__page_id').val(translit($('#Article__title').val()));
	}
}

function article_onChangePageID() {
	pageID_EditMode = ($('#Article__page_id').val() && true);
}

function translit(str) {
	return ru2en.tr_url(str);
}
</script>