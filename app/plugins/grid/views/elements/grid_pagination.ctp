<?
/**
 * Requires:
 * - initialized $this->Paginator (pagination object)
 * 
 * Params:
 * @param (str) iconset - folder name of iconset (Possible values: 'iconset1' - default value, 'iconset2')
 * 
*/
	$params = $this->Paginator->params();
?>
<table width="100%" class="grid_pagination" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width="30%">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="grid_sort"><span class="checkedStatus selected">&nbsp;</span></td>
			<td class="actions_checked">
<?
	foreach($checkedActions as $action) {
		if (is_array($action)) {
			echo $this->element($action[0], $action[1]);
		} else {
			echo $action;
		}
	}
?>
			</td>
		</tr>
		</table>
	</td>
	<td width="40%">
		<table align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right"><? __('Page');?>:</td>
			<td align="right"><?=$this->Paginator->first('<img src="/core/img/icons/first.gif" alt=""/>', array('escape' => false))?></td>
			<td><?=($this->Paginator->hasPrev()) ? $this->Paginator->prev('<img src="/core/img/icons/prev.gif" alt=""/>', array('escape' => false)) : ''?></td>
			<td class="gridFilter">
				<input class="gridFF" type="text" id="page" name="page" value="<?=$this->Paginator->current()?>" onfocus="this.select()" onchange="grid_onSubmitFilter();" style="width: 17px;" />
			</td>
			<td><?=($this->Paginator->hasNext()) ? $this->Paginator->next('<img src="/core/img/icons/next.gif" alt=""/>', array('escape' => false)) : ''?></td>
			<td><?=$this->Paginator->last('<img src="/core/img/icons/last.gif" alt=""/>', array('escape' => false))?></td>
			<td class="gridFilter" nowrap="nowrap">
		<? __('Show');?>: 
		<select class="gridFF" id="limit" name="limit" onchange="grid_onSubmitFilter();">
<?
		$perPage = array('5' => 5, '10' => 10, '20' => 20, '50' => 50, '1000' => 1000);
		foreach($perPage as $k => $value) {
			$selected = ($grid[$model]['limit'] == $k) ? ' selected="selected"' : '';
?>
			<option value="<?=$k?>"<?=$selected?>><?=$value?></option>
<?
		}
?>
		</select>
		<? __('per page');?>
			</td>
		</tr>
		</table>
	</td>
	<td width="30%" align="right" class="gridFilter" nowrap="nowrap" style="padding-left: 10px;">
		<? __('Pages');?>: 
		<select id="pageN" name="pageN" onchange="$('#page').val($('#pageN').val()); grid_onSubmitFilter(); ">
<?
		for($i = 1; $i <= $params['pageCount']; $i++) {
			$selected = ($this->Paginator->current() == $i) ? ' selected="selected"' : '';
?>
			<option value="<?=$i?>"<?=$selected?>><?=$i?></option>
<?
		}
?>
		</select>
		<?=$this->Paginator->counter(array('format' => __('View', true).' %start% - %end% '.__('of', true).' %count% '.__('records', true)));?>
	</td>
</tr>
</table>
<?
	// }
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#pageN').attr('autocomplete', 'off');
	$('#page').attr('autocomplete', 'off');
	$('#limit').attr('autocomplete', 'off');
});
</script>