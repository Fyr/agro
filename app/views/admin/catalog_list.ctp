<h2><?=__('Catalogs')?></h2>
<?
	$aActions = array(
		'table' => array(
			$this->element('icon_add', array('plugin' => 'core', 'href' => '/admin/catalogEdit/')),
			array('grid_table_showfilter', array('plugin' => 'grid'))
		),
		'row' => array(
			$this->element('icon_edit', array('plugin' => 'core', 'href' => '/admin/catalogEdit/{$id}')),
			array('grid_row_del', array('plugin' => 'grid')),
		)
	);
	
	$aRender = array(
		'fields' => array(
			'Catalog.descr' => array('catalog_renderfield_file') // не могу указать не сущ-ее поле :(
		)
	);
?>
<?=$this->PHGrid->render('Catalog', $aActions, $aRender)?>