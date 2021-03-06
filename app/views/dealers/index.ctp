                        <?=$this->element('title', array('title' => $content['Article']['title']))?>
<?
	foreach($aArticles as $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, '150x', $featured, $id);
?>
                        <div class="block clearfix">
<?
		if ($src) {
?>
                            <a href="<?=$url?>"><img src="<?=$src?>" alt="<?=$title?>" class="thumb"/></a>
<?
		}
?>
                            <a href="<?=$url?>" class="title"><?=$title?></a>
                            <?=$this->element('dealer_details', compact('article'))?>
                            <div class="description"><?=$teaser?></div>
                            <div class="more">
                                <?=$this->element('more', compact('url'))?>
                            </div>
                        </div>
<?
	}
?>
<?=$this->element('pagination', array('objectType' => 'dealers'))?>
<?=$this->HtmlArticle->fulltext($content['Article']['body'])?>
