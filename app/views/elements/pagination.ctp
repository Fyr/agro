<?
	if ($paginator->numbers()) {
		if (isset($filterURL) && $filterURL) {
			// $this->passedArgs['?'] = $filterURL;
		}
?>
<div class="pagination">
    <? __('Pages');?>:
    <?=$this->Router->transformPageParams($objectType, $paginator->prev('Предыдущая', array('escape' => false)))?>
    <?=$this->Router->transformPageParams($objectType, $paginator->numbers(array('separator' => ' ')))?>
    <?=$this->Router->transformPageParams($objectType, $paginator->next('Следующая', array('escape' => false)))?>
</div>
<?
	}
?>