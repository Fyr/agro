					<div class="area">
							<?=$this->element('title', array('title' => $page_title))?>
					</div>
<?
	if (!$aArticles) {
?>
	<div class="area">
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
			$title = $article['Article']['code'].' '.$article['Article']['title_rus'];
			if (!$src) {
				$media = $brands[$article['Article']['brand_id']]['Media'];
				if (isset($media[0]) && isset($media[0]['id']) && $media[0]['id']) {
					$media = $media[0];
					$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], '130x100', $media['file'].$media['ext']);
				}
				// $src = $this->PHMedia->getUrl($media['object_type'], $media['id'], $size, $file);
			}
			
?>
							<div class="block three" onclick="window.location.href= '<?=$url?>'">
								<h3>
<?
			if ($article['Article']['brand_id'] && isset($brands[$article['Article']['brand_id']])) {
?>
									<?=$brands[$article['Article']['brand_id']]['Brand']['title']?><br />
<?
			}
?>
									<a href="<?=$url?>"><?=$title?></a>
								</h3>
										<div class="image" style="text-align:center">
<?
			if ($article['Article']['active']) {
?>
											<img class="is_active" src="/img/active_yes.png" alt="В наличии" />
<?
			} else {
?>
											<img class="is_active" src="/img/active_no.png" alt="Не на складе" />
<?
			}
			if ($src) {
?>
											<a href="<?=$url?>"><img src="<?=$src?>" alt="<?=$title?>" /></a>
<?
			} else {
?>
											<img src='/img/default_product.jpg' alt="" style="width: 95px;"/>
<?
			}
?>
										</div>
										<?=$this->element('price', compact('article', 'prices', 'prices2'))?>
							</div>
<?
		}
?>
		<div class="clear"></div>
<?
		if (isset($directSearch) && $directSearch) {
			echo $this->element('pagination2', array('filterURL' => $aFilters['url']));
		} else {
			echo $this->element('pagination', array('objectType' => 'products'));
		}
?>
						</div>
					</div>
<?
	}

	if (isset($relatedContent) && $relatedContent) {
?>
					<div class="text" style="margin-top: 20px;">
						<?=$this->HtmlArticle->fulltext($relatedContent['Article']['body'])?>
					</div>
<?
		}
?>
