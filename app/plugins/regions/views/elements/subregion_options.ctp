<option value=""><? __('- all subregions -')?></option>
<?
	foreach($aSubregions as $region) {
		$selected = (isset($subregion_id) && $subregion_id == $region['Region']['id']) ? ' selected="selected"' : '';
?>
			<option value="<?=$region['Region']['id']?>" <?=$selected?>><?=$region['Region']['name']?></option>
<?
	}
?>
