<?
	foreach ($aArticles as $article) {
		
?>
	<a href="/articles/article/view/<?=$article['Article']['id']?>"><?=$article['Article']['title']?></a><br />
<?
	}
?>
<?=$this->element('pagination', array('plugin' => 'paginate'))?>
