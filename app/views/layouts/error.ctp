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
				<h1 class="logo"><a href="/" title="на Главную">&nbsp;</a></h1>
				<?=$this->element('main_menu')?>
				<div class="contacts">
					<span>+375 (29) 375 8113</span>
					<span>+375 (29) 375 8589</span>
					<address>223010, Минский район, 3-й км. МКАД, ПБ ОДО "Белпромстрой", каб. 211.</address>
				</div>
			</div><!-- header -->
			<div id="main">
				<div id="content">
<?
	if (TEST_ENV) {
?>
					<?=$content_for_layout?>
<?
	} else {
?>
									<div style="height: 300px">
										<h4>Страница не найдена</h4>
									    <p>Извините, запрашиваемая вами страница не существует.<br />
									      Воспользуйтесь навигацией или поиском, чтобы найти необходимую вам информацию.<br />
									      <br />
									      <a href="/">Перейти на Главную</a>
									    </p>
									</div>
<?
	}
?>
				</div><!-- content -->
				<div id="sidebar">
					
				</div><!-- sidebar -->
			</div><!-- main -->
		</div>
	</div><!-- wrapper -->
</div>
<div id="footer">
	<div class="holder">
		<div class="bottom">
			<strong class="logo"><a href="/" title="на Главную">&nbsp;</a></strong>
			<?=$this->element('bottom_links')?>
			<div class="info">
				<ul class="telephone">
					<li>+375 (29) 375 8113, +375 (29) 375 8589</li>
				</ul>
				<address>223010, Минский район, 3-й км. МКАД, ПБ ОДО "Белпромстрой", каб. 211.</address>
				<span class="copyright">&copy; 2012</span>
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