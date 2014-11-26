<?
	$id = $this->PHA->read($aArticle, 'Article.id');
	$pageTitle = ($id) ? 'Edit company' : 'New company';
	$page_id = $this->PHA->read($aArticle, 'Article.page_id');
	$seo_block = $this->element('admin_edit', array('plugin' => 'seo', 'data' => $aArticle, 'object_type' => 'Article'));
?>
<h2><? __($pageTitle)?></h2>
<?
	if ($id) {
?>
<div align="right" style="width: 550px">
	<!--a href="/admin/companiesGallery/<?=$id?>">Галерея фото</a><br/>
	<a href="<?=$this->Router->url($aArticle)?>" target="_blank" title="<? __('View this page on site in a new tab');?>"><? __('View page');?></a-->
</div>
<?
	}
?>
<div class="errMsg"><?=$errMsg?></div>
<form id="articleForm" name="articleForm" action="" method="post">
<input type="hidden" name="data[Article][object_type]" value="<?=$objectType?>" />
<input type="hidden" name="data[Company][id]" value="<?=$this->PHA->read($aArticle, 'Company.id')?>" />
<?
	if ($id) {
	}
	echo $this->element('wgt_exp_block', array('plugin' => 'core', 'id' => 'seo', 'caption' => 'SEO', 'content' => $seo_block));
	echo '<br />';
	echo $this->element('admin_edit_company');
?>
</form>
<?
	if ($id) {
?>
<form id="mediaForm" name="mediaForm" action="/media/media/submit/" method="post" enctype="multipart/form-data">
<input type="hidden" name="data[Media][inputName]" value="files" />
<input type="hidden" name="data[Media][object_type]" value="Article" />
<input type="hidden" name="data[Media][object_id]" value="<?=$this->PHA->read($aArticle, 'Article.id')?>" />
<input type="hidden" name="data[Media][makeThumb]" value="1" />
<?
	$backUrl = '/admin/companiesEdit/'.$id;
?>
<input type="hidden" name="data[backUrl]" value="<?=$backUrl?>" />
<br />
<?=$this->element('media_edit', array('plugin' => 'media', 'aMedia' => $aArticle['Media']))?>
</form>
<?
	}
?>