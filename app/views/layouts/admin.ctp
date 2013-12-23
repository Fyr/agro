<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=DOMAIN_TITLE?> - Admin Panel</title>

<?=$this->Html->charset()?>
<?=$this->Html->css(array('common', 'admin'))?>
<?=$this->Html->script(array('/core/js/jquery-1.5.1.min'))?>
<?
	// Scripts for ddaccordion plugin
	// echo $this->Html->css('/ddaccordion/css/ddaccordion');
	// echo $this->Html->script('/ddaccordion/js/ddaccordion');
	
	// For managing tables
	// echo $this->Html->css('/core/css/admin_table');
	
	// For categories
	echo $this->Html->css('/core/css/btn_icon');
?>

<?=$scripts_for_layout?>
<script type="text/javascript">
$(document).ready(function(){
	$('.autocompleteOff').attr('autocomplete', 'off');
});
</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
		&nbsp;&nbsp;<a href="/admin/">Главная</a> | <a href="/">К сайту</a> | <a href="/admin/logout">Выход</a>
	</td>
	<td align="right">Добро пожаловать, <b>admin</b>!&nbsp;&nbsp;</td>
</tr>
</table>
<div align="center"><h1><?=DOMAIN_TITLE?> CMS</h1></div>
<?=$this->element('admin_menu')?>
<div class="hr"></div>
<table align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<!-- Content panel -->
		<?=$content_for_layout?>
		<!-- /Content panel -->
	</td>
</tr>
</table>
</body>
</html>