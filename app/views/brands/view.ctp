<?=$this->element('title', array('title' => $aArticle['Article']['title']))?>
<div class="block main">
	<?=$this->HtmlArticle->fulltext($aArticle['Article']['body'])?>
</div>