<?
	if ($param['Param']['param_type'] == Param::OPTIONS) {
		$options = Param::options($param['Param']['options']);
		echo $options[$param['ParamValue']['value']];
	} else {
		echo $param['ParamValue']['value'];
	}
?>