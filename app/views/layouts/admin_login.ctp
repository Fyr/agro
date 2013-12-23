<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=DOMAIN_TITLE?> - Admin Panel</title>
<?=$this->Html->charset()?>
<?=$this->Html->css(array('common', 'admin'))?>
<?=$this->Html->script(array('/core/js/jquery-1.5.1.min'))?>
</head>
<body>
<br />
<div align="center"><h1><?=DOMAIN_TITLE?> CMS</h1></div>
<br />
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