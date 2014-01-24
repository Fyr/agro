<?
	$this->Html->script('/articles/js/translit_utf', array('inline' => false));

	$id = $this->PHA->read($aArticle, 'Article.id');
	$page_id = $this->PHA->read($aArticle, 'Article.page_id');
	if ($id) {
		$parentID = $this->PHA->read($aArticle, 'Category.object_id');
	} else {
		$parentID = $this->PHA->read($this->params, 'named.object_id');
	}
	$title = ($id) ? 'Edit' : 'New';
	$title.= ($parentID) ? ' subcategory' : ' category';
?>
<h2><? __($title)?></h2>
<?
	if ($id) {
?>
<div align="right" style="width: 550px">
	<a href="<?=$this->Router->catUrl('products', $aArticle['Category']);?>" target="_blank" title="Открыть в новой вкладке">Открыть каталог</a>
</div>
<?
	}
?>
<div class="errMsg"><?=$errMsg?></div>
<form id="articleForm" name="articleForm" action="" method="post">
<input type="hidden" name="data[Article][object_type]" value="<?=$objectType?>" />
<input type="hidden" name="data[Category][id]" value="<?=$this->PHA->read($aArticle, 'Category.id')?>" />
<?
	if ($parentID) {
?>
<input type="hidden" name="data[Category][object_id]" value="<?=$parentID?>" />
<?
	}
	$seo_block = $this->element('admin_edit', array('plugin' => 'seo', 'data' => $aArticle, 'object_type' => 'Article'));
	echo $this->element('wgt_exp_block', array('plugin' => 'core', 'id' => 'seo', 'caption' => 'SEO', 'content' => $seo_block));
?>
<table class="pad5" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td colspan="2">
		<input type="checkbox" id="Article.published" name="data[Article][published]" value="1" <?=($this->PHA->read($aArticle, 'Article.published')) ? 'checked="checked"' : ''?> /> <? __('Published');?>
	</td>
</tr>
<tr>
	<td><? __('Title');?></td>
	<td>
		<input type="text" class="autocompleteOff" id="Article__title" name="data[Article][title]" value="<?=$this->PHA->read($aArticle, 'Article.title')?>" size="68" "/> <!-- onkeyup="article_onChangeTitle() -->
<?
	if (isset($aErrFields['Article']['title'])) {
?>
		<span class="errNote"><? __($aErrFields['Article']['title']);?></span>
<?
	}
?>
	</td>
</tr>
<!--tr>
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
<script type="text/javascript">
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
	</td>
</tr-->
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Sorting order', true), 'class' => 'autocompleteOff', 'required' => true, 'field' => 'Category.sorting', 'data' => $aArticle, 'size' => 2))?>
<?// $this->element('std_input', array('plugin' => 'core', 'caption' => __('Page ID', true), 'class' => 'autocompleteOff', 'field' => 'Article.page_id', 'data' => $aArticle, 'size' => 78))?>
<tr>
	<td colspan="2">
		<? __('Description'); ?><br />
		<?=$this->PHFcke->textarea("data_Article__body_", $this->PHA->read($aArticle, 'Article.body'), 'Small')?>
	</td>
</tr>
<tr>
	<td align="center" colspan="2">
		<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.articleForm.submit()'))?>
	</td>
</tr>
</table>
</form>
<?
	if ($id) {
?>
<form id="mediaForm" name="mediaForm" action="/media/media/submit/" method="post" enctype="multipart/form-data">
<input type="hidden" name="data[Media][inputName]" value="files" />
<input type="hidden" name="data[Media][object_type]" value="Article" />
<input type="hidden" name="data[Media][object_id]" value="<?=$this->PHA->read($aArticle, 'Article.id')?>" />
<input type="hidden" name="data[Media][makeThumb]" value="1" />
<input type="hidden" name="data[backUrl]" value="/admin/typesEdit/<?=$id?>" />
<br />
<?=$this->element('media_edit', array('plugin' => 'media', 'aMedia' => $aArticle['Media']))?>
</form>
<?
	}
?>
