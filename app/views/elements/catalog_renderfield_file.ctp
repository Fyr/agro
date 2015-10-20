<td align="center">
<?
	if (isset($row['Media']) && $row['Media']) {
		foreach($row['Media'] as $media) {
			if ($media['media_type'] == 'raw_file') {
				$file = $media['file'].$media['ext'];
				echo $this->Html->link($file, $this->PHMedia->getRawUrl($media['object_type'], $media['id'], $file), array('target' => '_blank'));
				break;
			}
		}
	}
?>
</td>