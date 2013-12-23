<h2><?__('Products');?></h2>
<?
	$aActions = array(
		'table' => array(
			$this->element('icon_add', array('plugin' => 'core', 'href' => '/admin/productEdit/')),
			array('grid_table_showfilter', array('plugin' => 'grid'))
		),
		'row' => array(
			$this->element('icon_edit', array('plugin' => 'core', 'href' => '/admin/productEdit/{$id}')),
			array('grid_row_del', array('plugin' => 'grid'))
		)
	);
?>
<?=$this->PHGrid->render('SiteProduct', $aActions)?>