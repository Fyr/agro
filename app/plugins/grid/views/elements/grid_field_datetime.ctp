<td>
	<?=$this->PHTime->niceShort($value)?>
	<input type="hidden" id="<?=$field_id?>" name="data[<?=$alias?>][<?=$field?>]" value="<?=date('d.m.Y', strtotime($value))?>" />
</td>