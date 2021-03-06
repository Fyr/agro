<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?=$pageTitle?></title>
	<meta name="language" content="ru" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no, maximum-scale=1.0, initial-scale=1.0, minimum-scale=1.0">
<?=$this->element('seo_info', array('plugin' => 'seo', 'data' => $this->PHA->read($this->data, 'SEO')))?>
<?=$this->Html->charset()?>
<?=$this->Html->css(array('style', 'fonts', 'smoothDivScroll', 'extra', 'jquery.fancybox'))?>
<!--[if gte IE 9]>
<style type="text/css">
    .gradient { filter: none; }
</style>
<![endif]-->
<?
	$scripts = array(
		'jquery-1.11.0.min', 
		'jquery-ui-1.10.3.custom.min', 
		'jquery.mousewheel.min', 
		'jquery.kinetic.min', 
		'jquery.smoothdivscroll-1.3-min',
		'jquery.nivo.slider.pack',
		'jquery.fancybox.pack',
		'doc_ready'
	);
	if ($disableCopy) {
		$scripts[] = 'nocopy';
	}
?>
<?=$this->Html->script($scripts)?>
<?=$scripts_for_layout?>
<?
	if (isset($cat_autoOpen)) {
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#cat-nav<?=$cat_autoOpen?> > a').click();
});
</script>
<?
	}
?>
</head>
	<body>
		<div class="header">
            <div class="header_back">
                <div class="inner clearfix">
                   	<a href="/" class="logo"></a>
                   	<?=$this->element('main_menu')?>
                </div>
            </div>
            <div class="inner promoContent">
                <div class="right">
                    <div class="phones">
                        <span class="icon phone"></span>
                        <span class="numbers">
                            <?=PHONE?><br />
                            <?=PHONE2?>
                        </span>
                    </div>
                    <div class="address clearfix">
                        <a href="/contacts/#map" class="icon map"></a>
                        <span class="text"><?=ADDRESS?></span>
                    </div>
                </div>
                <div class="left">
                    <div class="skypeName">
                        <a href="callto:<?=SKYPE?>" class="icon skype"></a>
                        <a href="callto:<?=SKYPE?>"><?=SKYPE?></a>
                    </div>
                    <div class="letter">
                        <a href="mailto:<?=EMAIL?>" class="icon email"></a>
                        <a href="mailto:<?=EMAIL?>"><?=EMAIL?></a>
                    </div>
                </div>
                <img src="/img/header.png" alt="" class="promoPicture" />
            </div>
            
        </div>
        <div class="wrapper clearfix">
            <form class="searchBlock" action="/products/" method="get">
                <button class="submit">поиск</button>
                <div class="outerSearch"><input type="text" name="data[filter][Article.title]" placeholder="Введите номер или название запчасти..." /></div>
            </form>
            <div class="oneLeftSide">
                <div class="leftSidebar">
                    <?// $this->element('sidebar_left')?>
                </div>
            </div>

            <div class="mainColomn clearfix">
                <div id="mainContent" class="mainContent">
                    <div class="innerMainContent" <? if ($disableCopy) { ?>oncopy="return false;" onmousedown="return false;" onclick="return true;"<? } ?>>
<?
	// почему-то у баннеров не прогружается media
	if (isset($aSlot[1])) {
	}
	if (TEST_ENV) {
		echo $content_for_layout;
	} else {
?>
									<div style="height: 300px">
										<span class="h4">Страница не найдена</span>
										<p>Извините, запрашиваемая вами страница не существует.<br />
											Воспользуйтесь навигацией или поиском, чтобы найти необходимую вам информацию.<br />
											<br />
											<a href="/">Перейти на Главную</a>
										</p>
									</div>
<?
	}
?>


<?
	if (isset($aSlot[2])) {
	}
?>
                    </div>
                </div>
                <div class="rightSidebar">
                    <? // $this->element('sidebar_right')?>
                </div>
            </div>
        </div>
        <div class="wrapper">
<?
	if (isset($aHomePageNews)) {
?>

            <div class="headBlock">
                <div class="text">Новости нашей компании</div>
                <span class="corner"></span>
            </div>
            <div class="block clearfix">
<?
		foreach($aHomePageNews as $article) {
			$this->ArticleVars->init($article, $url, $title, $teaser, $src, '400x');
?>
                <div class="companyNews">
<?
			if ($src) {
?>
                    <img class="img-responsive" src="<?=$src?>" alt="<?=$title?>" />
<?
			}
?>
                    <div class="time"><span class="icon clock"></span><?=$this->PHTime->niceShort($article['Article']['created'])?></div>
                    <a href="<?=$url?>" class="title"><?=$title?></a>
                    <div class="description"><p><?=$teaser?></p></div>
                    <div class="more">
                        <?=$this->element('more', compact('url'))?>
                    </div>
                </div>
<?
		}
?>
            </div>
<?
	}
?>
        </div>
        <div class="footer">
            <div class="wrapper clearfix">
                <div class="content clearfix">
                    <a href="/" class="logo"></a>
                    <?=$this->element('bottom_links')?>
                    <div class="footerAddress">
                        <div class="phones">
                            <span class="icon phone"></span>
                            <span class="numbers">
                                <?=PHONE?><br />
                                <?=PHONE2?>
                            </span>
                        </div>
                        <div class="address clearfix">
                        	<a href="/contacts/#map" class="icon map"></a>
                        	<span class="text"><?=ADDRESS?></span>
                        </div>
                    </div>
                    <div class="footerSkypeEmail">
	                    <div class="skypeName">
	                        <a href="callto:<?=SKYPE?>" class="icon skype"></a>
	                        <a href="callto:<?=SKYPE?>"><?=SKYPE?></a>
	                    </div>
	                    <div class="letter">
	                        <a href="mailto:<?=EMAIL?>" class="icon email"></a>
	                        <a href="mailto:<?=EMAIL?>"><?=EMAIL?></a>
	                    </div>
                    </div>
                </div>
				<?=$this->element('counters')?>
                <img src="/img/footer_promo.png" class="footerPromo" alt="" />
            </div>
        </div>
        <div class="footerLine"></div>
<?
// 	if (!TEST_ENV) {
/*
 	<div style="position:fixed;top:50%;left:0px;">
<a id="mibew-agent-button" href="/app/webroot/mibew/chat?locale=ru" target="_blank" onclick="Mibew.Objects.ChatPopups['552c0eeae6c3cd3e'].open();return false;"><!--<img src="/app/webroot/mibew/b?i=mgreen&amp;lang=ru" border="0" alt="" />-->
<img src="/app/webroot/mibew/b?i=mgreen&amp;lang=ru" border="0" alt="" style="width: 38px; height: 160px;" />
</a><script type="text/javascript" src="/app/webroot/mibew/js/compiled/chat_popup.js"></script><script type="text/javascript">Mibew.ChatPopup.init({"id":"552c0eeae6c3cd3e","url":"\/app\/webroot\/mibew\/chat?locale=ru","preferIFrame":true,"modSecurity":false,"width":640,"height":480,"resizable":true,"styleLoader":"\/app\/webroot\/mibew\/chat\/style\/popup"});</script>
</div>
*/
	if (DOMAIN_NAME == 'agromotors.by') {
?>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'nzJOgSwy2Q';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<?
	} elseif (DOMAIN_NAME == 'agromotors.ru') {
?>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'z8unW7ZOIo';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<?
	}
?>
	</body>
</html>
