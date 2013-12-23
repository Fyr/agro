<?
	$id = $this->PHA->read($aParam, 'Param.id');
	$title = ($id) ? __('Edit parameter', true) : __('New parameter', true);
?>
<h1><?=$title?></h1>
<form action="" id="paramForm" name="paramForm" method="post">
<input type="hidden" name="data[Param][object_type]" value="ProductParam" />
<table class="pad5" cellpadding="0" cellspacing="0">
<?=$this->element('admin_edit', array('plugin' => 'params'))?>
<tr>
	<td colspan="2" align="center">
		<br />
		<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.paramForm.submit()'))?>
	</td>
</tr>
</table>
</form>
