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
		'row' => array(
			array('grid_row_edit', array('plugin' => 'grid')),
			array('grid_row_del', array('plugin' => 'grid'))
		)
	);
	if (isset($aType)) {
		$aActions['row'][] = '<a href="/admin/assocParams/{$id}">Tech.params</a>';
	} else {
		$aActions['row'][] = $this->element('icon_open', array('plugin' => 'core', 'href' => '/admin/typesList/{$id}', 'title' => 'Subtypes'));
	}
?>
<?=$this->PHGrid->render('Category', $aActions)?>
