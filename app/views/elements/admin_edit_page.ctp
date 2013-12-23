<?
	$this->Html->script('/articles/js/translit_utf', array('inline' => false));
?>
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td><? __('Title');?></td>
	<td>
		<input type="text" class="autocompleteOff" id="Article__title" name="data[Article][title]" value="<?=$this->PHA->read($aArticle, 'Article.title')?>" size="78" onkeyup="article_onChangeTitle()"/>
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
		<input type="text" class="autocompleteOff" id="Article__page_id" name="data[Article][page_id]" value="<?=$this->PHA->read($aArticle, 'Article.page_id')?>" size="78" onchange="article_onChangePageID()"/>
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
	</td>
</tr>
</table>