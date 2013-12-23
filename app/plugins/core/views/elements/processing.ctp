<?
/**
 * Renders image that is shown while request is processing
 * @param [str $class] - if set, $class is added to "class" attr
 * @param [str $id] - if set, "id" attr is added with $id value
*/
	$title = (!isset($title)) ? __('Processing...', true) : $title;
	$class = (!isset($class)) ? 'processing' : 'processing '.$class;
	$show = (isset($show) && $show);
	
	$style = '';
	$style.= (!$show) ? 'display: none; ' : '';
	$style = ($style) ? 'style="'.$style.'"' : ''
?>
<span <?=(isset($id)) ? 'id="'.$id.'" ' : ''?>class="<?=$class?>" <?=$style?>><img src="/core/img/ajax_loader.gif" alt="" /> <span><?=$title?></span></span>