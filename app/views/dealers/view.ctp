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
<div class="area">
	<?=$this->element('title', array('title' => $aArticle['Article']['title']))?>
<?
	if ($src) {
?>
	<img src="<?=$src?>" alt="<?=$title?>" style="float: left; margin: 0 10px 10px 0" />
<?
	}
?>
	<?=$this->element('dealer_details', array('article' => $aArticle))?>
	<div class="clear"></div>
	<div class="text">
		<?=$this->HtmlArticle->fulltext($aArticle['Article']['body'])?>
	</div>
</div>
