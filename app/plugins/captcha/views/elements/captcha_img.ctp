<?
	list($model, $field) = explode('.', $field);
?>
<img class="captcha" src="/captcha/captcha/index/<?=$captchaKey?>" style="border: 2px solid #ccc; float: left; margin: 5px;" alt="<? __('SPAM PROTECTION! Enter the text on image');?>" />
<? __('SPAM PROTECTION!');?><br/>
<? __('Enter the text on image');?>:<br/>
<input type="hidden" name="data[<?=$model?>][captcha_q]" value="<?=$captchaKey?>"/>
<input type="text" name="data[<?=$model?>][<?=$field?>]" value="" size="6"/><br />
<?
	if (isset($aErrFields[$model][$field])) {
?>
		<span class="errNote"><?=$aErrFields[$model][$field]?></span>
<?
	}
?>