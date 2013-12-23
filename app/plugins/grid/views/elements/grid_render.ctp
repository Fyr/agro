<?
	$this->Html->css('/grid/css/grid', null, array('inline' => false));
	$this->Html->script('/core/js/jquery.cookie', array('inline' => false));
	
	$this->Html->css('/core/css/nyroModal.css', null, array('inline' => false));
	$this->Html->script('/core/js/jquery.nyroModal.custom.min', array('inline' => false));
	
	// $model = $grid[$model]['alias'];
	
	$cols = count($grid[$model]['_fields']) + 1;
	$count = count($grid[$model]['rowset']);
	$checkAll_title = sprintf(__('Check %d records', true), $count);
	$uncheckAll_title = sprintf(__('Uncheck %d records', true), $count);
	
	if (isset($actions['table'])) {
		$tableActions = $actions['table'];
	} else {
		$tableActions = array(
			array('grid_table_add', array('plugin' => 'grid')),
			array('grid_table_showfilter', array('plugin' => 'grid'))
		);		
	}
	if (isset($actions['checked'])) {
		$checkedActions = $actions['checked'];
	} else {
		$checkedActions = array(
			array('grid_checked_del', array('plugin' => 'grid'))
		);
	}
	
	if ($checkedActions) {
		$cols++;
	}
	
	if (isset($actions['row'])) {
		$rowActions = $actions['row'];
	} else {
		$rowActions = array(
			array('grid_row_edit', array('plugin' => 'grid')),
			array('grid_row_del', array('plugin' => 'grid'))
		);		
	}
	
	$back_url = 'http://mcasterlive.dev/admin/newsList/page:1/limit:5';
	// $_url_params = '';
	
	// $back_url = '/'.$this->params['controller'].'/'.$this->params['action'].'/'
	$back_url = '/'.$this->params['url']['url'];
?>
<form id="gridForm" name="gridForm" action="" method="post" onsubmit="grid_onSubmitFilter(); return false;">
<table class="grid" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr>
<?
	if ($checkedActions) {
?>
	<th>
		<input type="checkbox" id="check_all" name="check_all" value="1" onclick="grid_onCheckAll(this)" />
	</th>
<?
	}
?>
	<th nowrap="nowrap">
<?
	// Actions always available for table
	foreach($tableActions as $action) {
		if (is_array($action)) {
			echo $this->element($action[0], $action[1]);
		} else {
			echo $action;
		}
	}
?>
	</th>
<?
	foreach($grid[$model]['_fields'] as $fieldID => $fieldInfo) {
		$title = $fieldInfo['caption'];
?>
	<th<?=($paginator->sortKey() == $fieldID) ? ' nowrap="nowrap"' : ''?>><?=$this->element('sort_field', array('plugin' => 'core', 'title' => $title, 'sortKey' => $fieldID))?></th>
<?
	}
?>
</tr>
</thead>
<tbody>
<tr class="gridFilter gridFilterRow hide">
<?
	if ($checkedActions) {
?>
	<td>&nbsp;</td>	
<?
	}
?>
	<td align="center" nowrap="nowrap">
		<?=$this->element('icon_action', array('plugin' => 'core', 'img' => 'filter_accept.png', 'onclick' => "grid_onSubmitFilter()", 'title' => __('Apply filter settings', true)))?>
		<?=$this->element('icon_action', array('plugin' => 'core', 'img' => 'filter_cancel.png', 'onclick' => "grid_onClearFilter()", 'title' => __('Clear filter settings', true)))?>
	</td>
<?
	foreach($grid[$model]['_fields'] as $fieldID => $fieldInfo) {
		$filterInfo = $grid[$model]['_filters'][$fieldID];
		
		$_title = '';
		$_class = 'gridFF';
		if (isset($filterInfo['error'])) {
			$_title = $filterInfo['error'];
			$_class.= ' gridFilterError';
		}
		if (strpos($filterInfo['size'], 'px') !== false) {
			$size = ' style="width: '.$filterInfo['size'].'"';
		} else {
			$size = ' size="'.$filterInfo['size'].'"';
		}
?>
	<td align="center">
<?
		if ($filterInfo['filterType'] == 'dropdown') {
?>
		<select class="<?=$_class?>" id="<?=$filterInfo['id']?>" name="<?=$filterInfo['id']?>">
<?
			if (!isset($filterInfo['filterOptions'][''])) { // пустая опция для неустановленного значения фильтра (фильтр не действует)
?>
			<option value="">&nbsp;</option>
<?
			}
			foreach($filterInfo['filterOptions'] as $key => $title) {
				// если нет точного сравнения - баг с показом текущего элемента из списка при значениях '' и 0 (ноль)
				$selected = ((string)$filterInfo['value'] === (string)$key) ? ' selected="selected"' : '';
?>
			<option value="<?=$key?>"<?=$selected?>><?=$title?></option>
<?
			}
?>
		</select>
<script type="text/javascript">
$(document).ready(function(){
	$('#<?=$filterInfo['id']?>').attr('autocomplete', 'off');
});
</script>
<?
		} elseif ($filterInfo['filterType'] == 'date_picker') {
			echo $this->element('calendar_input', array('plugin' => 'core', 'class' => $_class, 'name' => $filterInfo['id'], 'value' => $filterInfo['value'], 'title' => $_title));
		} elseif ($filterInfo['filterType'] == 'text') {
?>
		<input class="<?=$_class?>" type="text" id="<?=$filterInfo['id']?>" name="<?=$filterInfo['id']?>" value="<?=$filterInfo['value']?>" title="<?=$_title?>" onfocus="this.select()" <?=$size?>/>
<?
		}
?>
	</td>
<?
	}
?>
</tr>
<?
	$oddClass = 'even';
	if (!$grid[$model]['rowset']) {
?>
<tr class="gridRow <?=$oddClass?>">
	<td colspan="<?=$cols?>" align="center">
		<br />
<?
		__('No records found');
?>
		<br /><br />
	</td>
</tr>
<?
	}
	foreach ($grid[$model]['rowset'] as $row) {
		$oddClass = ($oddClass == 'even') ? 'odd' : 'even';
		$primaryKey = $grid[$model]['_primary'];
		$id = $row[$primaryKey['model']][$primaryKey['field']];
?>
<tr class="gridRow <?=$oddClass?>">
<?
		if ($checkedActions) {
?>
	<td class="first" align="center">
		<input type="checkbox" class="checkable" name="checked[]" value="<?=$id?>" onchange="grid_updateCheckings()" />
	</td>
<?
		}
?>
	<td <?=(!$checkedActions) ? 'class="first" ' : ''?> align="center" nowrap="nowrap">
<?
		foreach($rowActions as $action) {
			if (is_array($action)) {
				$action[1]['id'] = $id;
				$action[1]['row'] = $row;
				$action[1]['model'] = $model;
				$action[1]['back_url'] = $back_url;
				$action[1]['parity'] = $oddClass;
				echo $this->element($action[0], $action[1]);
			} else {
				echo str_replace('{$id}', $id, $action);
			}
		}
?>
	</td>
<?
		foreach($grid[$model]['_fields'] as $fieldID => $fieldInfo) {
			$filterInfo = $grid[$model]['_filters'][$fieldID];
			$value = $row[$fieldInfo['model']][$fieldInfo['field']];
			
			$action = array();
			if (isset($render['fields'][$fieldID])) {
				$action = $render['fields'][$fieldID];
			} else {
				$type = $fieldInfo['type'];
				$type = ($type == 'undefined') ? 'string' : $type;
				$action[0] = 'grid_field_'.$type;
				$action[1]['plugin'] = 'grid';
			}
			
			if (is_array($action)) {
				$action[1]['id'] = $id;
				$action[1]['row'] = $row;
				$action[1]['model'] = $model;
				$action[1]['alias'] = $grid[$model]['alias'];
				$action[1]['field'] = $fieldInfo['field'];
				$action[1]['back_url'] = $back_url;
				$action[1]['parity'] = $oddClass;
				$action[1]['value'] = $value;
				$action[1]['field_id'] = 'value_'.$filterInfo['id'].'_'.$id;
				$action[1]['filterOption'] = '';
				if ($filterInfo['filterType'] == 'dropdown' && $value && isset($filterInfo['filterOptions'][$value])) {
					$action[1]['filterOption'] = $filterInfo['filterOptions'][$value];
				}
				echo $this->element($action[0], $action[1]);
			} else {
				echo str_replace('{$value}', $value, $action);
			}
			/*
			if (isset($render['fields'][$fieldID])) {
				$action = $render['fields'][$fieldID];
				
				if (is_array($action)) {
					$action[1]['id'] = $id;
					$action[1]['row'] = $row;
					$action[1]['model'] = $model;
					$action[1]['back_url'] = $back_url;
					$action[1]['parity'] = $oddClass;
					echo $this->element($action[0], $action[1]);
				} else {
					echo str_replace('{$value}', $row[$fieldInfo['model']][$fieldInfo['field']], $action);
				}
			} else {
				$type = $fieldInfo['type'];
				$type = ($type == 'undefined') ? 'string' : $type;
				$value = $row[$fieldInfo['model']][$fieldInfo['field']];
				$action = array();
				$action[0] = 'grid_field_'.$type;
				$action[1]['plugin'] = 'grid';
				$action[1]['id'] = $id;
				$action[1]['row'] = $row;
				$action[1]['model'] = $model;
				$action[1]['back_url'] = $back_url;
				$action[1]['parity'] = $oddClass;
				$action[1]['value'] = $value;
				$action[1]['field_id'] = 'value_'.$filterInfo['id'].'_'.$id;
				
				echo $this->element($action[0], $action[1]);
				// echo $this->element('grid_field_'.$type, array('plugin' => 'grid', 'value' => $value, 'id' => $id, 'field_id' => 'value_'.$filterInfo['id'].'_'.$id));
			}
			*/
		}
?>
</tr>
<?
	}
?>
<tr>
	<td class="last th" colspan="<?=$cols?>" align="center">
		<?=$this->element('grid_pagination', array('plugin' => 'grid', 'model' => $model, 'checkedActions' => $checkedActions))?> <!-- , 'back_url' => $back_url -->
	</td>
</tr>
</tbody>
</table>
</form>


<div id="gridEditRec" style="display: none; width: 700px;">
<?=$this->element('grid_edit', array('plugin' => 'grid', 'grid' => $grid, 'model' => $model))?>
</div>

<script type="text/javascript">
$(document).ready(function() {
	if ($.cookie('gridFilterRow')) {
		$('.gridFilterRow').removeClass('hide');
	}
	grid_onCheckAll();
	$('.nyroModal').nyroModal();
});

var checkAll_title = '<?=$checkAll_title?>';
var uncheckAll_title = '<?=$uncheckAll_title?>';
var checked_title = '<? __('Records checked');?>';
var delChecked_title = '<? __('Are you sure to delete checked records?');?>';
var delChecked_url = '<?='/'.$this->params['controller'].'/gridAction/action:delete/model:'.$model.'/id:_ids_/?back_url='.rawurlencode($back_url)?>';
<?
	$aFields = array();
	foreach($grid[$model]['_fields'] as $fieldID => $fieldInfo) {
		$filterInfo = $grid[$model]['_filters'][$fieldID];
		$aFields[] = $filterInfo['id'];
	}
?>
var aFields = new Array("", "<?=implode('","', $aFields)?>");
function grid_onCheckAll() {
	var checkAll = $('#check_all').get(0);
	$('.checkable').attr('checked', checkAll.checked);
	grid_updateCheckings();
}

function grid_updateCheckings() {
	var checkAll = $('#check_all').get(0);
	var title = (checkAll.checked) ? uncheckAll_title : checkAll_title;
	
	$('.checkable').parent().parent().removeClass('gridSelectedRow');
	$('.checkable:checked').parent().parent().addClass('gridSelectedRow');
	
	// Update title for "check all"
	var checkedCount = $('.checkable:checked').size();
	var checkedTitle = (checkedCount) ? ' (' + checkedCount + ' ' + checked_title + ')' : '';
	$(checkAll).attr('title', title + checkedTitle);
	
	// Update checked status
	$('.checkedStatus').html((checkedCount) ? checkedCount + ' ' + checked_title : '');
	
	grid_updateActionsChecked();
}

function grid_updateActionsChecked() {
	var checkedCount = $('.checkable:checked').size();
	if (checkedCount) {
		$('.actions_checked').show();
	} else {
		$('.actions_checked').hide();
	}
}

function grid_onCheckedDel() {
	if (confirm(delChecked_title)) {
		var ids = new Array();
		$('.checkable:checked').each(function(){
			ids.push(this.value);
		});
		var url = delChecked_url.replace(/_ids_/g, ids.join());
		window.location.href = url;
		return true;
	}
	return false;
}

function grid_onFilter() {
	if ($('.gridFilterRow').hasClass('hide')) {
		// show
		$('.gridFilterRow').removeClass('hide');
		$.cookie('gridFilterRow', true, {expire: 365, path: '/'});
	} else { // hide
		$('.gridFilterRow').addClass('hide');
		$.cookie('gridFilterRow', null, {expire: 365, path: '/'});
	}
}

function grid_onSubmitFilter() {
	var url = window.location.href;
	var xurl = '';
	$('.gridFF').each(function() {
			var id = this.id.replace(/__/, '.');
			// alert(id + ': ' + $(this).val() + ' : ' + url.indexOf(id));
			if (url.indexOf(id + ':') == -1) { // not found
				
				if ($(this).val()) {
					xurl+= '/' + id + ':' + $(this).val();
				}
			} else {
				re = new RegExp('\/' + this.id.replace(/__/, '\\.') + ':[\\w%\\.\\*]*');	
				if ($(this).val()) {
					url = url.replace(re, '\/' + id + ':' + $(this).val());
				} else {
					url = url.replace(re, '');
				}
			}
	});
	url+= xurl;
	window.location.href = url;
	return false;
}

function grid_onClearFilter() {
	$('.gridFilterRow :input').val('');
	grid_onSubmitFilter();
}

function grid_onEdit(id) {
	for(var i = 1; i < aFields.length; i++) {
		var fieldID = aFields[i];
		var value = $('#value_' + fieldID + '_' + id).val();
		$('#edit_' + fieldID).val(value);
		$('#edit_' + fieldID).removeClass('gridFilterError');
	}
	$('#gridEdit_ID').val(id);
	$.nmManual('#gridEditRec');
}
</script>