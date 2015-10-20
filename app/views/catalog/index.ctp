                        <?=$this->element('title', array('title' => __('Catalogs', true)))?>
<?
	foreach($aArticles as $article) {
		// $this->ArticleVars->init($article, $url, $title, $teaser, $src, '150x', $featured, $id);
		$title = $article['Catalog']['title'];
		$teaser = $article['Catalog']['descr'];
		$src = '';
		$doc = '';
		if (isset($article['Media']) && $article['Media']) {
			foreach($article['Media'] as $media) {
				if ($media['media_type'] == 'image') {
					$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], '150x', $media['file'].$media['ext']);
				} elseif ($media['media_type'] == 'raw_file') {
					$doc = $this->PHMedia->getRawUrl($media['object_type'], $media['id'], $media['file'].$media['ext']);
				}
			}
		}
		$url = array(
			'view' => $article['Catalog']['url'], 
			'download' => ($doc) ? $this->Html->url(array('action' => 'download', $article['Catalog']['id'])) : ''
		);
		if (!$url['view'] && $doc) {
			$url['view'] = $doc;
		}
?>
                        <div class="block clearfix">
<?
		if ($src) {
?>
                            <a href="<?=$url['view']?>"><img src="<?=$src?>" alt="<?=$title?>" class="thumb"/></a>
<?
		}
?>
                            <!--div class="time"><span class="icon clock"></span></div-->
                            <a href="<?=$url['view']?>" class="title"><?=$title?></a>
                            <div class="description"><?=$teaser?></div>
                            <div class="more">
<?
		if ($url['view']) {
?>
                                <a href="<?=$url['view']?>">Посмотреть</a> 
<?
		}
		if ($url['download']) {
?>
                                <a href="<?=$url['download']?>">Скачать</a>
<?
		}
?>
                            </div>
                        </div>
<?
	}
?>
<?=$this->element('pagination', array('objectType' => 'Catalog'))?>
