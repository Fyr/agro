<?
	$this->Html->css('/core/css/admin_table', null, array('inline' => false));
?>
<h1>Plugin Articles list for Admin</h1>
<?=$this->element('admin_list', array('plugin' => 'articles', 'aActions' => $aActions))?>