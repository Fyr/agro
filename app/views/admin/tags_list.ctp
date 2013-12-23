<h2><?__('Categories');?></h2>
<?
	$aActions = array(
		'row' => array(
			array('grid_row_edit', array('plugin' => 'grid')),
			array('grid_row_del', array('plugin' => 'grid')),
			$this->element('icon_open', array('plugin' => 'core', 'href' => '/admin/subregionsList/{$id}'))
		)
	);
?>
<?=$this->PHGrid->render('Tag')?>
