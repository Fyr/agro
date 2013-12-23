					<div class="area" style="text-transform: uppercase;">
						<?=$this->element('title', array('title' => $contentArticle['Article']['title']))?>
						<div class="text" style="text-transform: none;">
							<?=$this->HtmlArticle->fulltext($contentArticle['Article']['body'])?>
						</div>
					</div>
					<div class="line"></div>
<?
	if ($aNews) {
?>

					<div class="section">
						<div class="s-frame">
							<?=$this->element('title', array('title' => 'Новости компаний'))?>
<?
		foreach($aNews as $article) {
			$this->ArticleVars->init($article, $url, $title, $teaser, $src, '80x');
?>
							<div class="block">
<?
			if ($src) {
?>
								<div class="image">
									<a href="<?=$url?>"><img src="<?=$src?>" alt="<?=$title?>" /></a>
								</div>
<?
			}
?>
								<h3><a href="<?=$url?>"><?=$title?></a></h3>
								<p><?=$teaser?></p>
								<a href="<?=$url?>" class="more"><?__('read more')?></a>
							</div>
<?
		}
?>

						</div>
					</div>
<?
	}
?>