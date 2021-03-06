<?=$this->element('title', array('title' => $page_title))?>
<?
	if (!$aArticles) {
?>
	<div class="block main clearfix">
		<b>Не найдено ни одного продукта</b>
		<p>
			Пож-ста, измените параметры поиска или нажмите
			<a href="/products">сюда</a>,
			чтобы просмотреть весь каталог продукции.
		</p>
	</div>
<?
	} else {
?>
	<div class="catalogContent clearfix<?=(isset($directSearch) && $directSearch) ? ' brands' : ''?>">
<?
		foreach($aArticles as $article) {
			$this->ArticleVars->init($article, $url, $title, $teaser, $src, '130x100', $featured);
			$title = $article['Article']['code'].' '.$article['Article']['title_rus'];
			$brand_id = $article['Article']['brand_id'];
			if (!$src) {
				if ($brand_id) {
					$media = $brands[$brand_id]['Media'];
					if (isset($media[0]) && isset($media[0]['id']) && $media[0]['id']) {
						$media = $media[0];
						$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], '130x100', $media['file'].$media['ext']);
					}
				}
			}
			
?>
							<div id="product_<?=$article['Article']['id']?>" class="block" onclick="window.location.href= '<?=$url?>'">
								<div class="top">
<?
			// if ($article['Article']['brand_id'] && isset($brands[$brand_id])) {
				if (isset($directSearch) && $directSearch) {
					$catTitle = $article['Category']['title'].' &gt; '.$article['Subcategory']['title']; // $brands[$article['Article']['brand_id']]['Brand']['title']
?>
									<div class="brand"><small><?=$catTitle?></small></div>
<?
				}
			// }
?>
									<a class="title" href="javascript:void(0)"><?=$title?></a>
								</div>
								<a class="ava" href="javascript:void(0)">
									<span class="icon <?=($article['Article']['active']) ? 'available' : 'noAvailable'?>"></span>
									<img src="<?=($src) ? $src : '/img/default_product100.png'?>" alt="<?=$title?>" />
								</a>
<?
			$price = 0;
			$prod_id = $article['Article']['id'];
			if ($_SERVER['SERVER_NAME'] == 'agromotors.ru') {
				if (isset($prices_ru[$prod_id])) {
					$price = $prices_ru[$prod_id]['value'];
				} elseif (isset($prices2_ru[$prod_id])) {
					$price = $prices2_ru[$prod_id]['value'];
				}
			} else {
				if (isset($prices_by[$prod_id])) {
					$price = $prices_by[$prod_id]['value'];
				}
			}
			if ($price) {
?>
								<div class="price"><?=PU_.$price._PU?></div>
<?
			}
?>
							</div>
<?
		}
?>                            
	</div>
<?
		if (isset($directSearch) && $directSearch) {
			echo $this->element('pagination2', array('filterURL' => $aFilters['url']));
		} else {
			echo $this->element('pagination', array('objectType' => 'products'));
		}
?>

<?
	}

	if (isset($relatedContent) && $relatedContent) {
?>
	<?=$this->HtmlArticle->fulltext($relatedContent['Article']['body'])?>
<?
	}
?>

<?
  if (isset($directSearch) && $directSearch) {
?>
<script>
	$(document).ready(function(){
		if ($(window).width() < 703 ) {
			$(".mainContent").prependTo($(".oneLeftSide"));
		}
        var flag1 = true;
        $(window).resize(function() {
            if ($(window).width() < 703 ) {
                if (flag1) {
				    $(".mainContent").prependTo($(".oneLeftSide"));
					
                    flag1 = false;
                }
            }
            else {
				$(".mainContent").prependTo($(".mainColomn"));
                flag1 = true;
            }
        });    
    });
</script>
<?
}
?>