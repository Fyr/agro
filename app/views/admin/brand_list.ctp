<h2><?__('Brands');?></h2>
<?
	$aActions = array(
		'table' => array(
			$this->element('icon_add', array('plugin' => 'core', 'href' => '/admin/brandEdit/')),
			array('grid_table_showfilter', array('plugin' => 'grid'))
		),
		'row' => array(
			$this->element('icon_edit', array('plugin' => 'core', 'href' => '/admin/brandEdit/{$id}')),
			array('grid_row_del', array('plugin' => 'grid'))
		)
	);
?>
<?=$this->PHGrid->render('SiteArticle', $aActions)?>