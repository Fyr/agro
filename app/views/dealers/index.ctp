					<div class="area">
							<?=$this->element('title', array('title' => __('Dealers', true)))?>
					</div>

<?
	foreach($aArticles as $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, '150x', $featured);
?>
					<div class="section">
						<div class="s-frame">
							<div class="block one">
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
								<?=$this->element('dealer_details', compact('article'))?>
								<p><?=$teaser?></p>
								<a class="more" href="<?=$url?>"><span><?__('read more')?></span></a>
							</div>
						</div>
					</div>
<?
	}
?>
<?=$this->element('pagination')?>
<div class="text">
	<?=$this->HtmlArticle->fulltext($content['Article']['body'])?>
</div>
