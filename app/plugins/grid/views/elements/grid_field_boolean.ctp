<td align="center">
	<?=($value) ? $this->element('icon_action', array('plugin' => 'core', 'img' => 'checked.png')) : ''?>
	<input type="hidden" id="<?=$field_id?>" name="data[<?=$alias?>][<?=$field?>]" value="<?=$value?>" />
</td>