<?
/**
 * Requires:
 * - $paginator - pagination object
 * Params:
 * @param (str) $title - field title
 * @param (str)	$sortKey - sort key (model.field)
 * 
*/
	if ($paginator->sortKey() == $sortKey) {
		$img = $paginator->sortDir().'.gif';
?>
		<table class="grid_sort" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td rowspan="2" class="selected"><?=$paginator->sort($title, $sortKey)?></td>
			<td valign="bottom"><?=$paginator->sort($html->image('/grid/img/icons/asc_h.gif'), $sortKey, array('escape' => false))?></td>
		</tr>
		<tr>
			<td valign="top"><?=$paginator->sort($html->image('/grid/img/icons/desc_h.gif'), $sortKey, array('escape' => false))?></td>
		</tr>
		</table>
<?
	} else {
?>
		<table class="grid_sort" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td rowspan="2"><?=$paginator->sort($title, $sortKey)?></td>
			<td valign="bottom"><?=$paginator->sort($html->image('/grid/img/icons/asc_h.gif'), $sortKey, array('escape' => false))?></td>
		</tr>
		<tr>
			<td valign="top"><?=$paginator->sort($html->image('/grid/img/icons/desc_h.gif'), $sortKey, array('escape' => false))?></td>
		</tr>
		</table>
		
<?
	}
?>
