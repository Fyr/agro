<?
	$id = $this->PHA->read($aArticle, 'Article.id');
	$page_id = $this->PHA->read($aArticle, 'Article.page_id');
?>
<h2><?=$pageTitle?></h2>
<?
	if ($id) {
?>
<div align="right" style="width: 550px">
<?
		if ($objectType == 'pages') {
?>
	<a href="<?=$this->Router->url($aArticle)?>" target="_blank" title="<? __('View this page on site in a new tab');?>"><? __('View page');?></a>
<?
		} else {
?>
	<a href="<?=$this->Router->url($aArticle)?>" target="_blank" title="<? __('View this article on site in a new tab');?>"><? __('View article');?></a>
<?
		}
?>
</div>
<?
	}
?>
<div class="errMsg"><?=$errMsg?></div>
<form id="articleForm" name="articleForm" action="" method="post">
<input type="hidden" id="catObj" name="data[Article][object_type]" value="<?=$objectType?>" />
<input type="hidden" id="catID" name="data[Article][object_id]" value="<?=$this->PHA->read($aArticle, 'Article.object_id')?>" />
<?
	$seo_block = $this->element('admin_edit', array('plugin' => 'seo', 'data' => $aArticle, 'object_type' => 'Page'));
	echo $this->element('wgt_exp_block', array('plugin' => 'core', 'id' => 'seo', 'caption' => 'SEO', 'content' => $seo_block));
	echo '<br />';
	if ($objectType == 'pages') {
		echo $this->element('admin_edit_page');
	} elseif (in_array($objectType, array('news', 'offers', 'motors'))) {
		echo $this->element('admin_edit_news');
	} else {
		echo $this->element('admin_edit', array('plugin' => 'articles'));
	}
?>
</form>
<?
	if ($id) {
?>
<form id="mediaForm" name="mediaForm" action="/media/media/submit/" method="post" enctype="multipart/form-data">
<input type="hidden" name="data[Media][inputName]" value="files" />
<input type="hidden" name="data[Media][object_type]" value="Page" />
<input type="hidden" name="data[Media][object_id]" value="<?=$this->PHA->read($aArticle, 'Article.id')?>" />
<input type="hidden" name="data[Media][makeThumb]" value="1" />
<input type="hidden" name="data[backUrl]" value="/admin/pagesEdit/<?=$id?>" />
<br />
<?=$this->element('media_edit', array('plugin' => 'media', 'aMedia' => $aArticle['Media']))?>
</form>
<?
	}
?>