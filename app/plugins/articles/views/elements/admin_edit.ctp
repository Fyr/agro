<?
	$this->Html->script('/articles/js/translit_utf', array('inline' => false));
?>
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td colspan="2">
		<input type="checkbox" id="Article.published" name="data[Article][published]" value="1" <?=($this->PHA->read($aArticle, 'Article.published')) ? 'checked="checked"' : ''?> /> <? __('Published');?>
		<input type="checkbox" id="Article.featured" name="data[Article][featured]" value="1" <?=($this->PHA->read($aArticle, 'Article.featured')) ? 'checked="checked"' : ''?> /> <? __('Featured');?>
	</td>
</tr>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Title', true), 'class' => 'autocompleteOff', 'required' => true, 'field' => 'Article.title', 'data' => $aArticle, 'size' => 78, 'onkeyup' => 'article_onChangeTitle()'))?>
<?//$this->element('std_input', array('plugin' => 'core', 'caption' => __('Page ID', true), 'class' => 'autocompleteOff', 'field' => 'Article.page_id', 'data' => $aArticle, 'size' => 78, 'onchange' => 'article_onChangePageID()'))?>
<!--
<tr>
	<td><? __('Title');?></td>
	<td>
		<input type="text" id="Article__title" name="data[Article][title]" value="<?=$this->PHA->read($aArticle, 'Article.title')?>" size="78" onkeyup="article_onChangeTitle()"/>
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
		<input type="text" id="Article__page_id" name="data[Article][page_id]" value="<?=$this->PHA->read($aArticle, 'Article.page_id')?>" size="78" onchange="article_onChangePageID()"/>
<?
	if (isset($aErrFields['Article']['page_id'])) {
?>
		<span class="errNote"><? __($aErrFields['Article']['page_id']);?></span>
<?
	}
?>
	</td>
</tr>
-->
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

<tr>
	<td colspan="2">
		<? __('Teaser'); ?><br />
		<textarea name="data[Article][teaser]" rows="1" cols="40" style="width: 550px; height: 100px"><?=$this->PHA->read($aArticle, 'Article.teaser')?></textarea>
	</td>
</tr>
<tr>
	<td colspan="2">
		<? __('Body'); ?><br />
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
<!--
</fieldset>
-->