<?
	$title = (isset($aType)) ? $aType['Article']['title'].': '.__('Subtypes', true) : __('Types', true);
?>
<h2><?=$title?></h2>
<?
	$aActions = array(
		'table' => array(
			$this->element('icon_add', array('plugin' => 'core', 'href' => '/admin/typesEdit/'.((isset($aType)) ? 'object_id:'.$aType['Article']['id'] : '') )),
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
		$aActions['row'][] = $this->element('icon_open', array('plugin' => 'core', 'href' => '/admin/typesList/{$id}', 'title' => __('Subtypes', true)));
	}
?>
<?=$this->PHGrid->render('SiteCategory', $aActions)?>
