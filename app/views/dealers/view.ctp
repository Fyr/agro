<style type="text/css">
.dealer-info {
	font-size: 1em;
	float: left;
}
.dealer-info span {
	display: block;
	margin-top: 5px;
}
</style>
<?
	$this->ArticleVars->init($aArticle, $url, $title, $teaser, $src, '200x');
?>
<?=$this->element('title', array('title' => $aArticle['Article']['title']))?>
<div class="block main">
<?
	if ($src) {
?>
	<img src="<?=$src?>" alt="<?=$title?>" style="float: right; margin: 0 0 10px 10px" />
<?
	}
?>
	<?=$this->element('dealer_details', array('article' => $aArticle))?>
	<div class="clear"></div>
	<?=$this->HtmlArticle->fulltext($aArticle['Article']['body'])?>
</div>
