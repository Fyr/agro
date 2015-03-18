<?=$this->element('title', array('title' => $contentArticle['Article']['title']))?>
<div class="block main">
	<?=$this->HtmlArticle->fulltext($contentArticle['Article']['body'])?>
</div>