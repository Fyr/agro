<td>
<?
	if ($value) {
?>
	<?=date('d.m.Y', strtotime($value))?>
<?
	}
?>
	<input type="hidden" id="<?=$field_id?>" name="data[<?=$alias?>][<?=$field?>]" value="<?=($value) ? date('d.m.Y', strtotime($value)) : ''?>" />
</td>