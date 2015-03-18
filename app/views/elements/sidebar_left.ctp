<?
	// echo $this->element('sbl_block', array('class' => 'types', 'content' => $this->element('sb_types')));
	echo $this->element('sbl_block', array('title' => 'Каталог', 'content' => $this->element('sb_types', compact('aTypes'))));
	if ($upcomingEvent) {
		// echo $this->element('sbl_block', array('title' => 'Новости', 'content' => $this->element('sb_news', array('article' => $upcomingEvent))));
	}
	echo $this->element('tag_cloud');
?>
