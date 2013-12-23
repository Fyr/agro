<h1>Смена пароля</h1>
<b><?=$this->Session->flash()?></b>
<form id="pageForm" name="pageForm" action="" method="post" enctype="multipart/form-data">
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<?=$this->element('std_input', array('plugin' => 'core', 'type' => 'password', 'caption' => 'Новый пароль', 'field' => 'UserProfile.password', 'data' => $data))?>
<?=$this->element('std_input', array('plugin' => 'core', 'type' => 'password', 'caption' => 'Повторите пароль', 'field' => 'UserProfile.password_again', 'data' => $data))?>
<tr>
	<td colspan="2" align="center">
		<br />
		<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.pageForm.submit()'))?>
	</td>
</tr>
</table>
</form>
<script type="text/javascript">
$(document).ready(function() {
	$('input').attr('autocomplete', 'off');
});
</script>