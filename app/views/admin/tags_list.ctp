<h2><?__('Categories');?></h2>
<?
	$aActions = array(
		'row' => array(
			array('grid_row_edit', array('plugin' => 'grid')),
			array('grid_row_del', array('plugin' => 'grid')),
			// $this->element('icon_del', array('plugin' => 'core', 'href' => 'http://agromotors.dev/admin/gridAction/action:delete/model:SiteCategory/id:1054/?back_url=%2Fadmin%2FtypesList%2F'))
			$this->element('icon_open', array('plugin' => 'core', 'href' => '/admin/subregionsList/{$id}'))
		)
	);
?>
<?=$this->PHGrid->render('Tag')?>
