<?
	$this->Html->css('/grid/css/grid', null, array('inline' => false));
?>
<form id="gridEditForm" name="gridEditForm" action="" method="post">
	<table class="gridEdit" border="0" cellpadding="0" cellspacing="0">
	<tbody>
<?
	foreach($grid[$model]['_fields'] as $fieldID => $fieldInfo) {
		$title = $fieldInfo['caption'];
		$filterInfo = $grid[$model]['_filters'][$fieldID];
		
		$_title = '';
		$_class = 'gridEditFF';
		$filterInfo['id'] = 'edit_'.$filterInfo['id'];
		
		if (strpos($filterInfo['size'], 'px') !== false) {
			$size = ' style="width: '.$filterInfo['size'].'"';
		} elseif ($filterInfo['filterType'] == 'text' && !in_array($fieldID, $grid[$model]['readonly'])) {
			$size = ' size="40"';
		} else {
			$size = ' size="'.$filterInfo['size'].'"';
		}
		$value = ''; // $grid[$model]['rowset'][0][$fieldInfo['model']][$fieldInfo['field']];
		$disabled = '';
		if (isset($grid[$model]['readonly']) && in_array($fieldID, $grid[$model]['readonly'])) {
			$disabled = ' disabled="disabled"';
		}
?>
	<tr>
		<td><?=$title?></td>
		<td>
<?
		if ($filterInfo['filterType'] == 'dropdown') {
			if (!$disabled) {
?>
		<select class="<?=$_class?>" id="<?=$filterInfo['id']?>" name="data[<?=$fieldInfo['model']?>][<?=$fieldInfo['field']?>]">
<?
				if (!isset($filterInfo['filterOptions'][''])) { // пустая опция для неустановленного значения фильтра (фильтр не действует)
?>
			<option value="">&nbsp;</option>
<?
				}
				foreach($filterInfo['filterOptions'] as $key => $title) {
				// если нет точного сравнения - баг с показом текущего элемента из списка при значениях '' и 0 (ноль)
				$selected = ((string)$value === (string)$key) ? ' selected="selected"' : '';
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
			} else {
				$_value = $filterInfo['filterOptions'][$value];
				
?>
		<input class="<?=$_class?>" type="text" id="<?=$filterInfo['id']?>" name="data[<?=$fieldInfo['model']?>][<?=$fieldInfo['field']?>]" value="<?=$_value?>" title="<?=$title?>" <?=$size?> <?=$disabled?>/>
		<!-- input type="hidden" id="<?=$filterInfo['id']?>" name="<?=$filterInfo['id']?>" value="<?=$value?>" /-->
<?
			}
		} elseif ($filterInfo['filterType'] == 'date_picker') {
			if (!$disabled) {
				echo $this->element('calendar_input', array('plugin' => 'core', 'class' => $_class, 'name' => $fieldID, 'value' => $value, 'title' => $_title, 'id' => $filterInfo['id'], 'onfocus' => 'this.select(); $(this).removeClass(\'gridFilterError\');'));
			} else {
				$_value = ($value) ? date('d.m.Y', strtotime($value)) : '';
?>
		<input class="<?=$_class?>" type="text" id="<?=$filterInfo['id']?>" name="data[<?=$fieldInfo['model']?>][<?=$fieldInfo['field']?>]" value="<?=$_value?>" title="<?=$title?>" <?=$size?> <?=$disabled?>/>
<?
			}
		} elseif ($filterInfo['filterType'] == 'text') {
			if ($fieldInfo['type'] == 'text') {
?>
		<textarea id="<?=$filterInfo['id']?>" class="textArea" name="data[<?=$fieldInfo['model']?>][<?=$fieldInfo['field']?>]" rows="3" cols="10" style="width: 200px; margin: 0; padding:0;"<?=$disabled?>><?=$value?></textarea>
<?
			} else {
?>
		<input class="<?=$_class?>" type="text" id="<?=$filterInfo['id']?>" name="data[<?=$fieldInfo['model']?>][<?=$fieldInfo['field']?>]" value="<?=$value?>" title="<?=$_title?>" onfocus="this.select(); $(this).removeClass('gridFilterError'); " <?=$size?> <?=$disabled?>/>
<?
			}
		} /* elseif ($filterInfo['filterType'] == 'hidden') {
?>
		!<input class="<?=$_class?>" type="hidden" id="<?=$filterInfo['id']?>" name="data[<?=$fieldInfo['model']?>][<?=$fieldInfo['field']?>]" value="<?=$value?>" />
<?
		}
		*/
?>
		</td>
	</tr>
<?
	}
?>
	<tr>
		<td align="center" colspan="2">
			<br />
			<?=$this->element('processing', array('plugin' => 'core', 'class' => 'ajaxLoader'))?>
			<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'gridEdit_onSubmit()'))?>
		</td>
	</tr>
	</tbody>
	</table>
	<input type="hidden" name="data[model]" value="<?=$model?>" />
	<input type="hidden" id="gridEdit_ID" name="data[id]" value="<?=($grid[$model]['_fields']) ? '' : ''?>" />
<?
	foreach($grid[$model]['_filters'] as $fieldID => $filterInfo) {
		if ($filterInfo['filterType'] == 'hidden') {
			$fieldInfo = $this->PHGrid->_denormalizeField($fieldID);
?>
	<input id="edit_<?=$fieldInfo['model']?>__<?=$fieldInfo['field']?>" type="hidden" name="data[<?=$fieldInfo['model']?>][<?=$fieldInfo['field']?>]" value="<?=$filterInfo['value']?>" />
<?
		}
	}
?>
</form>
<script type="text/javascript">
// function gridEdit_beforeSubmit()

function gridEdit_onSubmit() {
<?
	$url = '/'.$this->params['controller'].'/gridAction/action:submit/model:'.$model.'/id:'; // .$id.'/?back_url='.rawurlencode($back_url);
?>
	var url = '<?=$url?>';
	$('.btnIcon_save').hide();
	$('.ajaxLoader').show();
	$.post(url + $('#gridEdit_ID').val(), $('#gridEditForm').serialize(), function (data){ gridEdit_onComplete(data) }, 'JSON');
}

function gridEdit_onComplete(data) {
	$('.btnIcon_save').show();
	$('.ajaxLoader').hide();
	if (data.status == 'error') {
		for(fieldID in data.fields) {
			$('#' + fieldID).addClass('gridFilterError');
			$('#' + fieldID).get(0).title = data.fields[fieldID];
		}
	} else {
		$.nmTop().close();
		window.location.reload();
	}
}
</script>