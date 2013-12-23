<?
/**
 * Renders simple JS-managed list (add item, remove item)
 * @param [str $item] - HTML-code for item. You have to specify $item or $html
 * @param [str $element] - HTML-code for all list
 * @param [$class_prefix] - class prefix for multi-lists on a single page. Default value is 'jslist'
 * @param [str $js_onadd] - JS-code, included in add-fn
 * @param [str $js_ondel] - JS-code, included in del-fn
*/

	if (!isset($class_prefix)) {
		$class_prefix = 'jslist';
	}
	if (!isset($html_list)) {
?>
		<ul class="<?=$class_prefix?>_sample hide">
			<li id="<?=$class_prefix?>_item_ID">
				<?=$item?>
				<?=$this->element('icon_del', array('plugin' => 'core', 'class' => ' fixIcon', 'onclick' => $class_prefix."_onDel('".$class_prefix."_item_ID')"))?>
			</li>
		</ul>
		<ul class="<?=$class_prefix?>_container">
			<li style="display:none;">&nbsp;</li>
		</ul>
<?
	} else {
		echo $element;
	}
?>
<script type="text/javascript">
var <?=$class_prefix?>_count = 1;
var <?=$class_prefix?>_element = '';

$(document).ready(function(){
	if (!<?=$class_prefix?>_element) {
		<?=$class_prefix?>_element = $('.<?=$class_prefix?>_sample').html();
		$('.<?=$class_prefix?>_sample').remove();
	}	
});
function <?=$class_prefix?>_onAdd() {
	<?=$class_prefix?>_count++;
	html = <?=$class_prefix?>_element.replace(/<?=$class_prefix?>_item_ID/g, '<?=$class_prefix?>_item_' + <?=$class_prefix?>_count);
	$('.<?=$class_prefix?>_container').append(html);
<?
	if (isset($js_onadd)) {
		echo $js_onadd;
	}
?>
}

function <?=$class_prefix?>_onDel(id) {
	$('#' + id).remove();
<?
	if (isset($js_ondel)) {
		echo $js_ondel;
	}
?>
}
</script>
