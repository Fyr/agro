<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Title', true), 'field' => 'Param.title', 'data' => $aParam, 'required' => true))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Type', true), 'field' => 'Param.param_type', 'data' => $aParam, 'required' => true, 'input' => 'dropdown', 'options' => $aParamTypes, 'onchange' => "param_onChangeType(this)", 'class' => 'autocompleteOff'))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Required', true), 'field' => 'Param.required', 'data' => $aParam, 'input' => 'checkbox', 'class' => 'autocompleteOff'))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Options', true), 'field' => 'Param.options', 'data' => $aParam, 'input' => 'textarea', 'note' => __('Each item on new line', true)))?>
<?//$this->element('std_input', array('plugin' => 'core', 'caption' => 'Dropdown menu item', 'field' => 'Param.options', 'data' => $aParam))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Description', true), 'field' => 'Param.descr', 'data' => $aParam, 'input' => 'textarea'))?>
<script type="text/javascript">
function param_onChangeType() {
	$('#Param__options').get(0).disabled = ($('#Param__param_type').val() != <?=Param::OPTIONS?>);
}

$(document).ready(function() {
	param_onChangeType();
});
</script>