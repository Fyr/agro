<?
	$price = 0;
	$prod_id = $article['Article']['id'];
	if (Configure::read('params.price_ru')) {
		if (isset($prices) && isset($prices[$prod_id])) {
			$price = $prices[$prod_id]['value'];
		} elseif (isset($prices2) && isset($prices2[$prod_id])) {
			$price = $prices2[$prod_id]['value'];
		}
	} else {
		$price = $article['Article']['price'];
	}

	if ($price) {
?>
	<p class="price"><?=PU_.$price._PU?></p>
<?
	}
