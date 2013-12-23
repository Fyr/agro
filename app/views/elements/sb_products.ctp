<?
	foreach($aFeaturedProducts as $i => $article) {
		$title = $article['Article']['title'];
		$url = '/products/view/'.$article['Article']['id'];
		$body = $article['Article']['teaser'];
		
		$media = $article['Media'][0];
		$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], '85x', $media['file'].$media['ext']);
?>
					<a href="<?=$url?>" class="name"><?=$title?></a>
					<a href="<?=$url?>"><img src="<?=$src?>" alt="<?=$title?>" /></a>
					<p><?=$body?></p>
					<a href="<?=$url?>" class="more"><span>learn more</span></a>
					<div class="clear"></div>
					
					<div class="line"></div>
<?
	}
?>					
					<a href="/products/" class="view-all">All products</a>
					<br />
