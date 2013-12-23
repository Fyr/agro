<?
/**
 * Requires:
 * - $paginator - pagination object
 * Params:
 * @param (str) $title - field title
 * @param (str)	$sortKey - sort key (model.field)
 * 
 * Note! Pagination element must be invoked before sort field element,
 * else you must manually invoke paginator options setting
 * for ex.
 * 	$paginator->options(array('url' => array_merge($this->passedArgs, array('?' => $filterURL))));
*/
	if ($paginator->sortKey() == $sortKey) {
		$img = $paginator->sortDir().'.gif';
?>
		<span class="selected"><?=$paginator->sort($title, $sortKey)?></span>
		<?=$paginator->sort($html->image('/core/img/icons/'.$img), $sortKey, array('escape' => false))?>
<?
	} else {
?>
		<?=$paginator->sort($title, $sortKey)?>
<?
	}
?>
