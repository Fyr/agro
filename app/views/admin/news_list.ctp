<h1><? __('Manage news');?></h1>
<?

	$aActions = array(
		// 'checked' => array(),
		'row' => array(
			array('grid_row_edit', array('plugin' => 'grid')),
			array('grid_row_del', array('plugin' => 'grid')),
			array('article_rowaction_preview', array('plugin' => 'articles'))
		)
	);
	$aRender = array(
		'fields' => array(
			'Article.title' => array('article_renderfield_title', array('plugin' => 'articles'))
		)
	);

?>
<?=$this->element('grid_render', array('plugin' => 'grid', 'model' => 'SiteArticle', 'actions' => $aActions, 'render' => $aRender)) // ?>