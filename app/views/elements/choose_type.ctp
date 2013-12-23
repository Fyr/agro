<?
	foreach($aTypes['type_'] as $type) {
		if (isset($aTypes['type_'.$type['id']])) {
?>
							<optgroup label="<?=$type['title']?>">
<?
			$aTypeOptions = array();
			foreach($aTypes['type_'.$type['id']] as $subtype) {
				$aTypeOptions[$subtype['id']] = $subtype['title'];
			}
			echo $this->element('options', array('plugin' => 'core', 'options' => $aTypeOptions, 'selected' => $selected));
?>
							</optgroup>
<?
		}
	}
?>
