<?
/**
 * Renders element for media input
 * @param array $aAllowedTypes - allowed media types
 */

$aAllowedTypes = array('image', 'video', 'audio', 'raw_file');

if (!is_array($aAllowedTypes)) {
	$aAllowedTypes = array($aAllowedTypes);
}

$aAllowedTitles = array(
	"image" => __('Image', true),
	"video" => __('Video', true),
	"audio" => __('Audio', true),
	"raw_file" => __('PDF doc.', true)
);
if (count($aAllowedTypes) > 1) {
?>
	<select name="data[Media][MediaType][]">
<?
	foreach($aAllowedTypes as $type) {
		$title = $aAllowedTitles[$type];
?>
		<option value="<?=$type?>"><?=$title?></option>
<?
	}
?>
	</select>
<?
} else {
?>
	<input type="hidden" name="data[Media][MediaType][]" value="<?=$aAllowedTypes[0]?>" />
<?
}
?>
	<input type="file" name="files[]" />
