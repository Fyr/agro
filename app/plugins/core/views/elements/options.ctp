<?
/**
 * Renders options for <seect>
 * @param $options - array with $id => $title
 * @param $selected - selected item
*/
	foreach($options as $id => $title) {
		$_selected = ((string)$id === (string)$selected) ? ' selected="selected"' : '';
?>
	<option value="<?=$id?>"<?=$_selected?>><?=$title?></option>
<?
	}
?>
