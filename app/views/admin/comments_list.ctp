<h2><?__('Comments');?></h2>
<?
	$aActions = array(
	/*
		'table' => array(
			$this->element('icon_add', array('plugin' => 'core', 'href' => '/admin/articlesEdit/Article.object_type:'.$objectType)),
			array('grid_table_showfilter', array('plugin' => 'grid'))
		),
		*/
		'row' => array(
			array('grid_row_edit', array('plugin' => 'grid')),
			array('grid_row_del', array('plugin' => 'grid')),
			$this->element('icon_action', array('plugin' => 'core', 'path' => '/comments/img/icons/', 'img' => 'publish.png', 'title' => 'Publish comments', 'onclick' => 'publishRow({$id}, 1)')),
			$this->element('icon_action', array('plugin' => 'core', 'path' => '/comments/img/icons/', 'img' => 'unpublish.png', 'title' => 'Unpublish comments', 'onclick' => 'publishRow({$id}, 0)'))
		),
		'checked' => array(
			array('grid_checked_del', array('plugin' => 'grid')),
			$this->element('icon_action', array('plugin' => 'core', 'path' => '/comments/img/icons/', 'img' => 'publish.png', 'title' => 'Publish comments', 'onclick' => 'publishCheckedRows(1)')),
			$this->element('icon_action', array('plugin' => 'core', 'path' => '/comments/img/icons/', 'img' => 'unpublish.png', 'title' => 'Unpublish comments', 'onclick' => 'publishCheckedRows(0)'))
		)

	);
	$aRender = array(
		'fields' => array(
			'Comment.object_id' => array('comments_list_object_id')
		)
	);

?>
<?=$this->PHGrid->render('SiteComment', $aActions, $aRender)?>
<form id="form2" name="form2" action="/admin/commentsPublish" method="post">
<input type="hidden" id="publish" name="data[publish]" value="1" />
<input type="hidden" id="ids" name="data[ids]" value="" />
<input type="hidden" id="back_url" name="data[back_url]" value="<?=$this->PHGrid->backUrl()?>" />
</form>
<script type="text/javascript">
function publishRow(id, publishValue) {
	$('#publish').val(publishValue);
	$("#ids").val(id);
	document.form2.submit();
}

function publishCheckedRows(publishValue) {
	$('#publish').val(publishValue);
	submitCheckedRows();
}

function submitCheckedRows() {
	var ids = new Array();
	$(".checkable:checked").each(function(){
		ids.push(this.value);
	});
	$("#ids").val(ids.join(","));
	document.form2.submit();
}
</script>
