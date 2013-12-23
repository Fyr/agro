<h2><? __('Settings')?></h2>
<?
	if (isset($this->params['url']['success'])) {
?>
<div style="color: #00f; margin: 20px; font-weight: bold;">Настройки успешно сохранены</div>
<?
	}
?>
<form id="settingsForm" name="settingsForm" action="" method="post">
<table class="pad5" cellpadding="0" cellspacing="0">
<?
	foreach($data as $input) {
		echo $this->element('std_input', array_merge(array('plugin' => 'core'), $input));
	}
?>
</table>
<br/>
<fieldset>
<legend>Адреса, телефоны</legend>
<table class="pad5" cellpadding="0" cellspacing="0">
<?
	foreach($data2 as $input) {
		echo $this->element('std_input', array_merge(array('plugin' => 'core'), $input));
	}
?>
</table>
</fieldset>

<div align="center">
		<br/>
		<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.settingsForm.submit()'))?>
</div>
</form>