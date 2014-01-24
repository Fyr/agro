<?
	if (!isset($aType)) {
?>
<h2><?__('Types');?></h2>
<?
	} else {
?>
<h2><?=$aType['Category']['title']?>: <?__('Subtypes');?></h2>
<?
	}
?>
<?
	$aActions = array(
		'table' => array(
			$this->element('icon_add', array('plugin' => 'core', 'href' => '/admin/typesEdit/'.((isset($aType)) ? 'object_id:'.$aType['Category']['id'] : '') )),
			array('grid_table_showfilter', array('plugin' => 'grid'))
		),
		'row' => array(
			$this->element('icon_edit', array('plugin' => 'core', 'href' => '/admin/typesEdit/{$id}')),
			array('grid_row_del', array('plugin' => 'grid'))
		)
	);
	if (isset($aType)) {
		$aActions['row'][] = '<a href="/admin/assocParams/{$id}">Tech.params</a>';
	} else {
		$aActions['row'][] = $this->element('icon_open', array('plugin' => 'core', 'href' => '/admin/typesList/{$id}', 'title' => 'Subtypes'));
	}
?>
<?=$this->PHGrid->render('SiteCategory', $aActions)?>
