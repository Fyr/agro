<table class="pad5" cellpadding="0" cellspacing="0">

<?
	$i = -1;
	foreach($aParams as $param) {
		$i++;
		$param = $param['Param'];
		$aPassed = array('plugin' => 'core', 'class' => 'autocompleteOff', 'caption' => __($param['title'], true), 'field' => 'ParamValue.param_'.$param['id'], 'name' => 'data[ParamValue]['.$i.'][value]');
		
		$input = 'text';
		if ($param['param_type'] == Param::STRING) {
			$aPassed['size'] = '40';
		} elseif ($param['param_type'] == Param::TEXT) {
			$input = 'textarea';
		} elseif ($param['param_type'] == Param::OPTIONS) {
			$input = 'dropdown';
			$aPassed['options'] = Param::options($param['options']);
		} elseif ($param['param_type'] == Param::BOOL) {
			$input = 'checkbox';
		}
		
		$aPassed['input'] = $input;
		$aPassed['value'] = $this->PHA->read($data, 'ParamValue.'.$i.'.value');
		
		if ($param['required']) {
			$aPassed['required'] = true;
		}
		
?>
<?=$this->element('std_input', $aPassed)?>
<tr>
	<td>
		<input type="hidden" name="data[ParamValue][<?=$i?>][param_id]" value="<?=$param['id']?>" />
	</td>
</tr>
<?
	}
?>
</table>