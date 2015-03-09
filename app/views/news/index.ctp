					<div class="area">
							<?=$this->element('title', array('title' => __('News', true)))?>
					</div>

<?
	foreach($aArticles as $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, '150x', $featured, $id);
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
								<p><?=$teaser?></p>
								<a class="more" href="<?=$url?>"><span><?__('read more')?></span></a>
							</div>
						</div>
					</div>
<?
	}
?>
<?=$this->element('pagination', array('objectType' => 'news'))?>
