<h2><?=$aCategory['Category']['title']?> <? echo ': '; __('Associate parameters');?></h2>
<form id="paramForm" name="paramForm" action="" method="post">
<?=$this->element('admin_bind', array('plugin' => 'params'))?>
<div align="center">
	<br />
	<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.paramForm.submit()'))?>
</div>
</form>
<script type="text/javascript">
function onCheckAll() {
	var checkAll = $('#checkAll').get(0);
	$('.checkable').attr('checked', checkAll.checked);
}
</script>