<div id="banner" style="margin-bottom: 20px;">
<?
	$options = array();
	for($i = 1; $i <= 7; $i++) {
		echo $this->Html->image('banner/banner'.$i.'.png', $options);
		$options = array('style' => 'display: none');
	}
?>
</div>
<?
	if ($upcomingEvent) {
		echo $this->element('sbr_block', array('title' => 'Новости', 'content' => $this->element('sb_news', array('article' => $upcomingEvent))));
	}
?>
