<!-- form id="regionsForm" action="" method="post" -->
<table class="pad5 regions" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td><? __('Region')?>
		<select class="autocompleteOff" name="data[RegionObject][region_id]" onchange="regions_onChangeRegion(this)">
			<option value=""><? __('- all regions -')?></option>
<?
	foreach($aRegions as $region) {
		$selected = (isset($aRegionObject['RegionObject']['region_id']) && $aRegionObject['RegionObject']['region_id'] == $region['Region']['id']) ? ' selected="selected"' : '';
?>
			<option value="<?=$region['Region']['id']?>" <?=$selected?>><?=$region['Region']['name']?></option>
<?
	}
?>
		</select>
	</td>
	<td>
		<?=$this->element('processing', array('plugin' => 'core'))?>
	<span id="subregions">
		<? __('Subregion')?>
		<select class="autocompleteOff" name="data[RegionObject][subregion_id]">
<?
	if (isset($aRegionObject['RegionObject']['region_id']) && $aRegionObject['RegionObject']['region_id']) {
		echo $this->element('subregion_options', array('plugin' => 'regions', 'aSubregions' => $aSubregions, 'subregion_id' => $aRegionObject['RegionObject']['subregion_id']));
	} else {
?>
			<option value=""><? __('- choose region -')?></option>
<?
	}
?>
		</select>
	</span>
	</td>
</tr>
</table>
<input type="hidden" name="data[RegionObject][object_type]" value="<?=$object_type?>" />
<input type="hidden" name="data[RegionObject][object_id]" value="<?=$object_id?>" />
<?
	if (isset($aRegionObject['RegionObject']['id']) && $aRegionObject['RegionObject']['id']) {
?>
<input type="hidden" name="data[RegionObject][id]" value="<?=$aRegionObject['RegionObject']['id']?>" />
<?
	}
?>
<!-- /form -->
<script type="text/javascript">
function regions_onChangeRegion(select) {
	region_id = $(select).val();
	
	if (region_id) {
		$('#subregions').hide();
		$('.regions .processing').show();
		$('#subregions select').load('/regions/ajax/subregionOptions/' + region_id, null, function(){ $('#subregions').show(); $('.regions .processing').hide(); });
	} else {
		$('#subregions select').html('<' + 'option value=""><? __('- choose region -')?></' + 'option>');
	}
}
</script>