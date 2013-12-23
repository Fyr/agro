<?
	$url = '/news/view/'.$article['Article']['id'];
	$title = $article['Article']['title'];
	$body = $article['Article']['teaser'];
?>
								<p><?=$body?></p>
								<a href="<?=$url?>" class="more">подробнее</a>
								<a href="/news/" class="button">Все новости</a>