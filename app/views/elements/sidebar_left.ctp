<?
	// echo $this->element('sbl_block', array('class' => 'types', 'content' => $this->element('sb_types')));
	echo $this->element('categories');
	if ($upcomingEvent) {
		echo $this->element('sbl_block', array('title' => 'Новости', 'content' => $this->element('sb_news', array('article' => $upcomingEvent))));
	}
	echo $this->element('sbl_block', array('title' => 'Поиск', 'content' => $this->element('sb_search')));
	if ($aFeaturedProducts) {
		// $this->element('sbl_block', array('class' => 'products', 'content' => $this->element('sb_products')));
	}
	echo $this->element('tag_cloud');
?>
