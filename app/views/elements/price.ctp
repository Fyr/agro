<?
	$price = 0;
	$prod_id = $article['Article']['id'];
	if ($_SERVER['SERVER_NAME'] == 'agromotors.ru') {
		if (isset($prices) && isset($prices[$prod_id])) {
			$price = $prices[$prod_id]['value'];
		} elseif (isset($prices2) && isset($prices2[$prod_id])) {
			$price = $prices2[$prod_id]['value'];
		}
	} else {
		$price = $article['Article']['price'];
	}

	if ($price) {
		echo PU_.$price._PU;
	}
