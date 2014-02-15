					<div class="area">
							<?=$this->element('title', array('title' => $page_title))?>
					</div>
<?
	if (!$aArticles) {
?>
	<div>
		<b>Не найдено ни одного продукта</b>
		<p>
			Пож-ста, измените параметры поиска или нажмите
			<a href="/products/"><?__('here');?></a>,
			чтобы просмотреть весь каталог продукции.
		</p>
	</div>
<?
	} else {
?>
					<div class="section">
						<div class="s-frame">
<?
		foreach($aArticles as $article) {
			$this->ArticleVars->init($article, $url, $title, $teaser, $src, '130x100', $featured);
?>
							<div class="block three" onclick="window.location.href= '<?=$url?>'">
								<h3><a href="<?=$url?>"><?=$title?></a></h3>
<?
			if ($src) {
?>
										<div class="image" style="text-align:center">
											<a href="<?=$url?>"><img src="<?=$src?>" alt="<?=$title?>" /></a>
										</div>
<?
			}
?>
<?
			if ($article['Article']['price']) {
?>
								<p class="price"><?=PU_.$article['Article']['price']._PU?></p>
<?
			}
?>
								<p class="price"><?=($article['Article']['active']) ? 'в наличии' : 'нет на складе'?></p>


							</div>
<?
		}
		if (isset($directSearch) && $directSearch) {
			echo $this->element('pagination2', array('filterURL' => $aFilters['url']));
		} else {
			echo $this->element('pagination', array('objectType' => 'products'));
		}
		if (isset($relatedContent) && $relatedContent) {
?>
						<div class="text" style="margin-top: 20px;">
							<?=$this->HtmlArticle->fulltext($relatedContent['Article']['body'])?>
						</div>
<?
		}
?>
						</div>
					</div>
<?
	}

?>
