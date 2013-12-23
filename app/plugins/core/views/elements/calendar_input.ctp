<?
/**
 * Renders a "calendar" input control for dates
 * Params can contain the attrs for <input type="text"> tag. For ex. you can pass 'size': 
 * $this->element('calendar_input', array('plugin' => 'core', 'size' => 10))
 * Handled attrs: 'id', 'name', 'value', 'size', 'maxsize', 'class', 'title', 'mouseover', 'mouseout', 'onfocus', 'onblur'
 * 
 * Notes:
 * 		$name - can be passed in 'ModelName.some_field' format 
 * 			this way name will be translated to 'data[ModelName][some_field]'
 * 			(for ex. for 'name' => 'Article.article_date' will be <input type="text" name="data[Article][article_date]">)
 * 		$id - if $id contains chars '.', '[' or ']', these chars will be translated to '_' 
 * 			due to invalidness of these chars for HTML id attr. By default $id equals to $name
 * 		$value - must be passed as SQL date (YYYY-MM-DD)
 * 		$_value - directly inserted value for input
 * 
 */
	
	$this->Html->css(array('/core/css/jscal2/css/jscal2', '/core/css/jscal2/css/border-radius'), null, array('inline' => false));
	$this->Html->script(array('/core/js/jscal2', '/core/js/jscal2_ru'), array('inline' => false));
	
	if (strpos($name, '.') !== false) {
		$name = 'data['.implode('][', explode('.', $name)).']';
	}
	
	if (!isset($id)) {
		$id = str_replace(array('[', ']', '.'), '_', $name);
	}
	
	if (isset($value) && $value) {
		$value = date('d.m.Y', strtotime($value));
	} else {
		$value = '';
	}
	
	if (isset($_value)) {
		$value = $_value;
	}
	
	if (!isset($dateFormat)) {
		$dateFormat = '%d.%m.%Y';
	}
	
	if (!isset($size)) {
		$size = 8;
	}
	
	if (!isset($title)) {
		
	}
	
	$attrs = '';
	foreach(compact('id', 'name', 'value', 'size', 'maxsize', 'class', 'title', 'mouseover', 'mouseout', 'onfocus', 'onblur') as $attr => $value) {
		$attrs .= ' '.$attr.'="'.$value.'"';
	}
?>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td valign="middle"><input type="text"<?=$attrs?> /></td>
	<td valign="middle" style="padding-left: 2px;"><a id="<?=$id?>_trigger" href="javascript:void(0)" title="<?=__('Choose a date from calendar')?>"><img src="/core/img/icons/calendar.png" alt="" /></a></td>
</tr>
</table>
<script type="text/javascript">
Calendar.setup({
	trigger    : "<?=$id?>_trigger",
	inputField : "<?=$id?>",
	dateFormat : '<?=$dateFormat?>',
	onSelect   : function() { this.hide(); }
});
$(document).ready(function(){
	$('#<?=$id?>').attr('autocomplete', 'off');
})
</script>
