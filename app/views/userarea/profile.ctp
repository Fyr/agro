<h1>Мой профиль</h1>
<b><?=$this->Session->flash()?></b>
<form id="pageForm" name="pageForm" action="" method="post" enctype="multipart/form-data">
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<?//$this->element('std_input', array('plugin' => 'core', 'caption' => 'Ваше имя', 'field' => 'User.username', 'data' => $data))?>
<tr>
	<td>Ваше имя</td>
	<td>
		<input type="text" name="data[UserProfile][username]" value="<?=$this->PHA->read($data, 'UserProfile.username')?>" disabled="disabled" />
	</td>
</tr>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => 'Реальное имя (фамилия)', 'field' => 'UserProfile.f_name', 'data' => $data))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => 'Реальное имя (имя)', 'field' => 'UserProfile.l_name', 'data' => $data))?>
<tr>
	<td>Пол</td>
	<td>
<?
	$aOptions = array('1' => 'Мужской', '0' => 'Женский');
	foreach($aOptions as $value => $title) {
		$checked = ($data['UserProfile']['gender'] == $value) ? 'checked="checked"' : '';
?>
		<input type="radio" name="data[UserProfile][gender]" value="<?=$value?>" <?=$checked?> /> <?=$title?>
<?
	}
?>
	</td>
</tr>
<tr>
	<td>Ваше фото</td>
	<td>
		<input type="file" name="photo">
		<input type="hidden" name="data[Media][inputName]" value="photo" />
		<input type="hidden" name="data[Media][object_type]" value="Avatar" />
		<input type="hidden" name="data[Media][object_id]" value="<?=$currUID?>" />
		<input type="hidden" name="data[Media][makeThumb]" value="1" />
		<input type="hidden" name="data[Media][MediaType]" value="image" />
	</td>
</tr>
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