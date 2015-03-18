                        <?=$this->element('title', array('title' => __('News', true)))?>
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
                            <div class="time"><span class="icon clock"></span><?=$this->PHTime->niceShort($article['Article']['created'])?></div>
                            <a href="<?=$url?>" class="title"><?=$title?></a>
                            <div class="description"><?=$teaser?></div>
                            <div class="more">
                                <?=$this->element('more', compact('url'))?>
                            </div>
                        </div>
<?
	}
?>
<?=$this->element('pagination', array('objectType' => 'news'))?>
