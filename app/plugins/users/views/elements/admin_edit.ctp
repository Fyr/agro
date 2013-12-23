<!--
<fieldset style="width: 570px;">
<legend><?__('Article');?></legend>
-->
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td colspan="2">
		<input type="checkbox" id="Article.published" name="data[Article][published]" value="1" <?=($this->PHA->read($aArticle, 'Article.published')) ? 'checked="checked"' : ''?> /> <? __('Published');?>
	</td>
</tr>
<tr>
	<td><? __('Title');?></td>
	<td>
		<input type="text" id="Article.title" name="data[Article][title]" value="<?=$this->PHA->read($aArticle, 'Article.title')?>" size="40" />
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
	<td colspan="2">
		<? __('Body'); ?><br />
		<?=$this->PHFcke->textarea("data_Article__body_", $this->PHA->read($aArticle, 'Article.body'), 'Small')?>
	</td>
</tr>
<tr>
	<td align="center" colspan="2">
		<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.articleForm.submit()'))?>
		<!-- <?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.articleForm.submit()', 'text' => __('Save & View list', true)))?> -->
	</td>
</tr>
</table>
<!--
</fieldset>
-->