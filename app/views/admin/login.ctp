<?
	echo '<div class="error">';
	echo $this->Session->flash('auth');
	echo '</div>';
?>
<form action="" method="post" id="UserLoginForm">
<input type="hidden" name="_method" value="post" />
<table align="center" border="0" cellpadding="5" cellspacing="5">
<tr>
	<td><? __('Login');?></td>
	<td><input type="text" id="UserUsername" value="" name="data[User][username]"/></td>
</tr>
<tr>
	<td><? __('Password');?></td>
	<td><input type="password" id="UserPassword" value="" name="data[User][password]"/></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="<? __('Log in')?>"></td>
</tr>
</table>
</form>
