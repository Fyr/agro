<?
	$this->Html->script('/articles/js/translit_utf', array('inline' => false));
?>
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Title', true), 'class' => 'autocompleteOff', 'required' => true, 'field' => 'Article.title', 'data' => $aArticle, 'size' => 78, 'onkeyup' => 'article_onChangeTitle()'))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Page ID', true), 'class' => 'autocompleteOff', 'field' => 'Article.page_id', 'data' => $aArticle, 'size' => 78, 'onchange' => 'article_onChangePageID()'))?>
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