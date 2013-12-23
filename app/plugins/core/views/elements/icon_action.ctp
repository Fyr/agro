<?
/**
 * Renders an action icon (link with image). 
 * Params can contain attributes for <a> tag. For ex. you can pass one of params 'style' => 'font-weight: bold'.
 * Possible attrs: 'id', 'class', 'href', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout'
 * @param [(str) $path] - path to icons. Default value is '/core/img/icons/'
 * @param (str) $img - file name of icon image 
 * @param [(mixed) $confirm] - message for confirmation if link was clicked. If true, $confirm contains a std message
 * @param [, (str) $attr, ... (str) $attrs] - attributes for <a> tag
 * 
 * Handled attrs:
 * $class - default value is 'icon', if this param is started with ' ', class attr is added to default, else replaced
 * $href - default value is 'javascript:void(0)'
 * $onclick - if $confirm param is set, contains JS-code for confirmation
 */
	if (strpos($img, '/') === false) {
		$path = (isset($path)) ? $path : '/core/img/icons/';
	} else {
		$path = '';
	}
	$href = (isset($href)) ? $href : 'javascript:void(0)';
	
	if (isset($confirm) && is_bool($confirm)) {
		$confirm = __('Are you sure?', true);
	}
	
	if (isset($confirm)) {
		$onclick = 'return confirm(\''.$confirm.'\')';
	}

	// $class = (isset($class)) ? 'icon '.$class : 'icon';
	if (!isset($class)) {
		$class = 'icon';
	} elseif (substr($class, 0, 1) === ' ') {
		$class = ('icon '.$class);
	}
	$attrs = '';
	foreach(compact('id', 'class', 'href', 'title', 'onclick', 'style', 'target', 'mouseover', 'mouseout') as $attr => $value) {
		$attrs .= ' '.$attr.'="'.$value.'"';
	}
?>
<a<?=$attrs?>><img src="<?=$path.$img?>" border="0" alt=""/></a>