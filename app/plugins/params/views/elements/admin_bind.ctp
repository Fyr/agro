<?
	$this->Html->css('/grid/css/grid', null, array('inline' => false));
?>
<table class="grid" align="center" cellpadding="0" cellspacing="0">
<thead>
	<tr>
		<th>
			<input type="checkbox" class="checkbox autocompleteOff" id="checkAll" name="checkAll" value="" onclick="onCheckAll()" />
		</th>
		<th><?__('Param.title');?></th>
		<th><?__('Type');?></th>
		<th><?__('Description');?></th>
	</tr>
</thead>
<?
	$class = '';
	foreach($aParams as $param) {
		$class = ($class == 'odd') ? 'even' : 'odd';
		$param = $param['Param'];
		$checked = (in_array($param['id'], $aBinded)) ? 'checked="checked"' : '';
?>
<tr class="gridRow <?=$class?>">
	<td>
		<input type="checkbox" class="checkbox checkable autocompleteOff" name="data[ParamObject][]" value="<?=$param['id']?>" <?=$checked?>/>
	</td>
	<td><?=$param['title']?></td>
	<td><?=$aParamTypes[$param['param_type']]?></td>
	<td><?=$param['descr']?></td>
</tr>
<?
	}
?>
</table>
<script type="text/javascript">
function onCheckAll() {
	var checkAll = $('#checkAll').get(0);
	$('.checkable').attr('checked', checkAll.checked);
}
</script>