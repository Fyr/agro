<?
	if ($upcomingEvent) {
		echo $this->element('sbr_block', array('title' => 'Новости', 'content' => $this->element('sb_news', array('article' => $upcomingEvent))));
	}
?>
