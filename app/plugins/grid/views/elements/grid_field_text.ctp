<td>
	<?=$this->Text->truncate($value, 40)?>
	<input type="hidden" id="<?=$field_id?>" name="data[<?=$alias?>][<?=$field?>]" value="<?=htmlspecialchars($value)?>" />
</td>