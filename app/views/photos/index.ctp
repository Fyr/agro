<h1><?=$title?></h1>
<div class="photos">
<?
	$category = ''; // $article[0]['Category']['id'];
	foreach ($aArticles as $article) {
		$url = '/article/view/';
		if ($article['Article']['page_id']) {
			$url.= $article['Article']['page_id'];
		} else {
			$url.= $article['Article']['id'];
		}
		if ($category !== $article['Category']['id']) {
			$category = $article['Category']['id'];
			if (isset($article['Category']['title']) && $article['Category']['title']) {
?>
			<!-- output here category -->
<?
			}
		}
?>
                                                    <h2><a href="<?=$url?>"><?=$article['Article']['title']?></a></h2>
<?
		if (isset($article['Media'][0])) {
			foreach($article['Media'] as $media) {
				if ($media['media_type'] == 'image') {
?>

                                                    <div class="image_back">
	    											    <div class="sides_frame"><a href="#" style="background-image: url('upload/1.jpg')"></a></div>
		    											<div class="bottom_frame"></div>
			    									</div>
                                                    <div class="image_back center">
					    							    <div class="sides_frame"><a href="#" style="background-image: url('upload/photo1.jpg')"></a></div>
						    							<div class="bottom_frame"></div>
							    					</div>
                                                    <div class="image_back">
									    			    <div class="sides_frame"><a href="#" style="background-image: url('upload/1.jpg')"></a></div>
										    			<div class="bottom_frame"></div>
											    	</div>
                                                    <div class="links">
														<?=$this->element('article_stats', array('article' => $article))?>                                                    </div>
                                                    <div class="more"><a href="#">Смотреть все фото</a></div>
<?
					break;
				}
			}
		}
		$teaser = $article['Article']['teaser'];
?>


<?
	}
?>
</div>
<?=$this->element('pagination', array('plugin' => 'paginate'))?>

<div class="pager">
    <span class="prev">Предыдущая</span>
    <span class="current">1</span>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <span class="next"><a href="#">Следующая</a></span>
</div>

