<?php
class PHAHelper extends Helper {

	function read($aData, $keys, $defaultValue = '') {
		$keys = str_replace('\.', '!', $keys);
		$aKeys = explode('.', $keys);

		foreach($aKeys as $key) {
			$key = str_replace('!', '.', $key);
			if (!isset($aData[$key])) {
				return $defaultValue;
			} else {
				$aData = $aData[$key];
			}
		}

		return $aData;
	}
}