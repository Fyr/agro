<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<title><?=$pageTitle?></title>
	<meta name="language" content="ru" />
<?=$this->element('seo_info', array('plugin' => 'seo', 'data' => $this->PHA->read($this->data, 'SEO')))?>
<?=$this->Html->charset()?>
<?=$this->Html->css(array('all', 'extra'))?>
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="/css/ie.css" />
	<![endif]-->
<?=$this->Html->script(array('jquery-1.7.1.min', 'menu', 'custom'))?>
<?=$scripts_for_layout?>
</head>
<body>
<div class="lines">
	<div id="wrapper">
		<div class="w-holder">
			<div id="header">
				<div class="logo"><a href="/" title="на Главную">&nbsp;</a></div>
				<?=$this->element('main_menu')?>
				<div class="contacts">
					<span><?=PHONE?>&nbsp;</span>
					<span><?=PHONE2?>&nbsp;</span>
					<address><?=ADDRESS?></address>
				</div>
			</div><!-- header -->
			<div id="main">
				<div id="content">
					<?=$content_for_layout?>
				</div><!-- content -->
				<div id="sidebar">
					<?=$this->element('sidebar_left')?>
				</div><!-- sidebar -->
			</div><!-- main -->
		</div>
	</div><!-- wrapper -->
</div>
<div id="footer">
	<div class="holder">
		<strong class="headline">наши партнеры</strong>
		<div id="slider" class="logos-move-wrapper">
			<div class="arrow-left"></div>
			<div class="logos-move">
				<div class="left"></div>
				<div class="view">
					<div class="mover">
						<div class="mover-in">
<?
	for($i = 1; $i <= 3; $i++) {
		foreach($aBrands as $article) {
			$this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');
?>
									<a href="<?=$url?>"><img src="<?=$src?>" alt="<?=$title?>" style="height: 60px;" /></a>
<?
		}
	}
?>

						</div>
					</div>
				</div>
				<div class="right"></div>
			</div>
			<div class="arrow-right"></div>
		</div><!-- slider -->
		<div class="bottom">
			<strong class="logo"><a href="/" title="на Главную">&nbsp;</a></strong>
			<?=$this->element('bottom_links')?>
			<div class="info">
				<ul class="telephone">
<?
	$aPhones = array(PHONE);
	if (PHONE2) {
		$aPhones[] = PHONE2;
	}
?>
					<li><?=implode(', ', $aPhones)?></li>
				</ul>
				<address><?=ADDRESS?></address>
				<span class="copyright">Разработка сайта: <a href="mailto:fyr@tut.by">fyr@tut.by</a></span>
			</div><!-- info -->
		</div><!-- bottom -->
		<div class="shadow-left"></div>
		<div class="shadow-right"></div>
	</div>
</div><!-- footer -->
<?
	if (!TEST_ENV) {
		/*
<!-- Yandex.Metrika informer -->
<a href="http://metrika.yandex.ru/stat/?id=19618108&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/19618108/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:19618108,type:0,lang:'ru'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->
		*/
?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter19618108 = new Ya.Metrika({id:19618108,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/19618108" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?
	}
?>
</body>
</html>