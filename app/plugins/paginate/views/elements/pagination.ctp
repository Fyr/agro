<?
/**
 * Requires:
 * - initialized $paginator (pagination object)
 * 
 * Params:
 * @param (str) iconset - folder name of iconset (Possible values: 'iconset1' - default value, 'iconset2')
 * 
*/
	// $this->Html->css('/paginate/css/pagination', null, array('inline' => false));
	$iconset = 'iconset1';
	if ($paginator->numbers()) {
?>
    <div class="pager">
        <? /* __('Pages'); */?>
    	<? /* $paginator->first('<img src="/paginate/img/'.$iconset.'/first.gif" alt=""/>', array('escape' => false)) */?>
	    <span class="prev"><?=$paginator->prev('Предыдущая', array('escape' => false))?></span>
    	<?=$paginator->numbers()?>
	    <span class="next"><?=$paginator->next('Следующая', array('escape' => false))?></span>
    	<? /* $paginator->last('<img src="/paginate/img/'.$iconset.'/last.gif" alt=""/>', array('escape' => false)) */?>
    </div>
<?
	}
?>