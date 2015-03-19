<?=$this->element('title', array('title' => $contentArticle['Article']['title']))?>
<div class="block main clearfix">
	<?=$this->HtmlArticle->fulltext($contentArticle['Article']['body'])?>
</div>