<?
	if ($banner['Banner']['type'] == BannerType::HTML) {
		echo $banner['Banner']['options']['html'];
	} elseif ($banner['Banner']['type'] == BannerType::IMAGE) { 
		$w = min($min_w, $banner['Media'][0]['orig_w']);
		$h = floor($banner['Media'][0]['orig_h'] * $w / $banner['Media'][0]['orig_w']);
		$style = "width: {$w}px; height: {$h}px; margin: 10px 0 20px 0; display: block;";
		$media = $banner['Media'][0];
		$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], ($media['orig_w'] > $min_w) ? $min_w.'x' : 'noresize', $media['file'].$media['ext']);
?>
<a href="<?=$banner['Banner']['options']['url']?>" style="<?=$style?>">
	<img src="<?=$src?>" alt="<?=$banner['Banner']['options']['alt']?>" />
</a>
<?
	} elseif ($banner['Banner']['type'] == BannerType::SLIDER) {
		$w = min($min_w, $banner['Media'][0]['orig_w']);
		$h = floor($banner['Media'][0]['orig_h'] * $w / $banner['Media'][0]['orig_w']);
		$style = "width: {$w}px; height: {$h}px; margin: 10px 0 20px 0";
?>
<a href="<?=$banner['Banner']['options']['url']?>">
<div id="banner<?=$banner['Banner']['id']?>" class="nivoSlider" style="<?=$style?>">
<?
	$options = array();
	foreach($banner['Media'] as $media) {
		$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], ($media['orig_w'] > $min_w) ? $min_w.'x' : 'noresize', $media['file'].$media['ext']);
		echo $this->Html->image($src, $options);
		$options = array('style' => 'display: none;');
	}
?>
</div>
</a>
<?
	}
?>