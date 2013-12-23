<?
	$iconset = 'iconset1';
	if ($paginator->numbers()) {
		if (isset($filterURL) && $filterURL) {
			// $this->passedArgs['?'] = $filterURL;
		}

		// $paginator->options(array('url' => $this->passedArgs));
?>
<table align="center" class="pagination" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td align="right" style="padding-right: 5px;"><? __('Pages');?>:</td>
	<td><?=$this->Router->transformPageParams($objectType, $paginator->prev('Предыдущая', array('escape' => false)))?></td>
	<td align="center" nowrap="nowrap" style="padding: 0px 5px;"><?=$this->Router->transformPageParams($objectType, $paginator->numbers())?></td>
	<td><?=$this->Router->transformPageParams($objectType, $paginator->next('Следующая', array('escape' => false)))?></td>
</tr>
</table>
<?
	}
?>