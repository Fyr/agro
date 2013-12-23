<?
/**
 * Renders a button with action icon. 
 * Params can contain attributes for <a> tag. For ex. you can pass one of params 'style' => 'font-weight: bold'.
 * Possible attrs: 'class', 'href', 'id', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout'
 * @param (str) $title - content for tag <a> and its attribute "title"
 * @param [(str) $path] - path to icons. Default value is '/core/img/icons/'
 * @param [(str) $img] - file name of icon image 
 * @param [(mixed) $confirm] - message for confirmation if link was clicked. If true, $confirm contains a std message
 * @param [, (str) $attr, ... (str) $attrs] - attributes for <a> tag
 * 
 * Handled attrs:
 * $class - default value is 'btnIcon', if this param is started with ' ', class attr is added to default, else replaced
 * $href - default value is 'javascript:void(0)'
 * $onclick - if $confirm param is set, contains JS-code for confirmation
 */
	$this->Html->css('/core/css/btn_icon.css', null, array('inline' => false));
	
	$href = (isset($href)) ? $href : 'javascript:void(0)';
	
	if (isset($confirm) && is_bool($confirm)) {
		$confirm = __('Are you sure?', true);
	}
	
	if (isset($confirm)) {
		$onclick = 'return confirm(\''.$confirm.'\')';
	}

	$class = (isset($class)) ? 'btnIcon '.$class : 'btnIcon';
	
	if (!isset($style)) {
		$style = '';
	}
	if (isset($img)) {
		if (strpos($img, '/') === false) {
			$path = (isset($path)) ? $path : '/core/img/icons/';
		} else {
			$path = '';
		}
		$style = ('background-image: url('.$path.$img.');'.$style);
	}
	
	$attrs = '';
	foreach(compact('class', 'href', 'id', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout') as $attr => $value) {
		$attrs .= ' '.$attr.'="'.$value.'"';
	}
?>
<a<?=$attrs?>><?=$title?></a>