<?
/**
 * Renders simple input control with error handling. Control is rendered as row of table
 * @param [str $caption] - caption for control. Omit this param to exclude extra HTML-code for control
 * @param str $field - string representation for field (Model.FieldName)
 * @param [str $data] - data for field
 * @param [bool $required] - flag to display a field as required
 * @param [str $note] - note under field
 * @param [str $input] - string (default)\date\dropdown\checkbox
 * @param [array options] - options for dropdown
 * @param [str $extra] - extra HTML-code for field
 * @param [array $aErrFields] - array with errors
 * @param [, (str) $attr, ... (str) $attrs] - attributes for <input> tag
 * 	Possible attrs: 'type', 'id', 'name', 'value', 'size', 'class', 'title', 'onchange', 'onblur', 'onfocus', 'style', 'mouseover', 'mouseout'
*/

	if (!isset($caption)) {
		$caption = false;
	}

	list($model, $field) = explode('.', $field);
	if (!isset($id)) {
		$id = $model.'__'.$field;
	}
	
	if (!isset($name)) {
		$name = 'data['.$model.']['.$field.']';
	}
	
	if (!isset($input)) {
		$input = 'string';
	} elseif ($input == 'checkbox') {
		$type = 'checkbox';
	}
	
	if (!isset($type) && $input == 'string') {
		$type = 'text';
	}
	
	if (!isset($options)) {
		$options = array();
	}
	
	if (!isset($value)) {
		$value = $this->PHA->read($data, $model.'.'.$field);
	}

	if (!isset($required)) {
		$required = false;
	}
	
	if (!isset($extra)) {
		$extra = '';
	}
	
	if (!isset($note)) {
		$note = '';
	}
	
	if ($input == 'textarea' && (!isset($rows) || !isset($cols)) ) {
		$rows = 3;
		$cols = 40;
	}
	
	$attrs = '';
	foreach(compact('type', 'id', 'name', 'size', 'class', 'title', 'onchange', 'onblur', 'onfocus', 'style', 'mouseover', 'mouseout', 'onkeyup', 'rows', 'cols') as $attr => $val) {
		$attrs .= ' '.$attr.'="'.$val.'"';
	}
	if ($caption) {
?>
<tr>
	<td>
		<?=(($required) ? '<span class="required">*</span> ' : '').$caption?><br />
		<span class="note"><?=$note?></span>
	</td>
	<td>
<?
	}
	if ($input == 'dropdown') {
?>
		<select <?=$attrs?>>
<?	
		if (!$required) {
			echo '<option value=""></option>';
		}
		foreach($options as $val => $option) {
			$selected = ((string)$val === (string)$value) ? 'selected="selected"' : '';
?>
			<option value="<?=$val?>" <?=$selected?>><?=$option?></option>
<?
		}
?>
		</select>
<?
	} elseif ($input == 'textarea') {
?>
		<textarea <?=$attrs?>><?=$value?></textarea>
<?
	} elseif ($input == 'checkbox') {
		$checked = ($value) ? 'checked="checked"' : '';
		if ($input == 'checkbox' && !$value) {
			$value = 1;
		}
?>
	<input <?=$attrs.' '.$extra?> value="<?=$value?>" <?=$checked?>/>
<?
	} else {
?>
		<input <?=$attrs.' '.$extra?> value="<?=$value?>"/>
<?
	}
	if (isset($aErrFields[$model][$field])) {
?>
		<span class="errNote"><?=$aErrFields[$model][$field]?></span>
<?
	}
	if ($caption) {
?>
	</td>
</tr>
<?
	}
?>