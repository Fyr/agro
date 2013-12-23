<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<?=$this->element('std_input', array('plugin' => 'core', 'data' => $aUser, 'caption' => __('User name', true), 'field' => 'User.username', 'aErrFields' => $aErrFields))?>
<?=$this->element('std_input', array('plugin' => 'core', 'data' => $aUser, 'caption' => __('Email', true), 'field' => 'User.email', 'aErrFields' => $aErrFields))?>
<?=$this->element('std_input', array('plugin' => 'core', 'data' => $aUser, 'caption' => __('Password', true), 'field' => 'User.password', 'type' => 'password', 'aErrFields' => $aErrFields))?>
<?=$this->element('std_input', array('plugin' => 'core', 'data' => $aUser, 'caption' => __('Password again', true), 'field' => 'User.password_again', 'type' => 'password', 'aErrFields' => $aErrFields))?>
<tr>
	<td align="center" colspan="2">
		<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.usersForm.submit()', 'title' => __('Register now', true)))?>
	</td>
</tr>
</table>
