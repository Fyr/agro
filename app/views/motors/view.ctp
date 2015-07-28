<?
	$this->PHCore->css(array('jquery.fancybox'));
	$this->PHCore->js(array('jquery.fancybox.pack.js')); 
?>
<?=$this->element('title', array('title' => $aArticle['Article']['title']))?>
<div class="block main clearfix">
	<?=$this->HtmlArticle->fulltext($aArticle['Article']['body'])?>
</div>
