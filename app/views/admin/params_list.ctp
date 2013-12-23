<h2><?__('Tech.parameters');?></h2>
<?
	$aActions = array(
		'table' => array(
			array('icon_add', array('plugin' => 'core', 'href' => '/admin/paramEdit/')),
			array('grid_table_showfilter', array('plugin' => 'grid'))
			// $this->element('icon_open', array('plugin' => 'core', 'href' => '/admin/subregionsList/{$id}'))
		),
		'row' => array(
			$this->element('icon_edit', array('plugin' => 'core', 'href' => '/admin/paramEdit/{$id}')),
			array('grid_row_del', array('plugin' => 'grid')),
		)
	);
	$aRender = array(
		'fields' => array(
			'Param.param_type' => array('grid_renderfield_showoption', array('plugin' => 'grid'))
		)
	);
?>
<?=$this->PHGrid->render('Param', $aActions, $aRender)?>
