<?
	if ($paginator->numbers()) {
		
		if (isset($filterURL) || isset($aFilterArgs)) {
			if (isset($aFilterArgs)) {
				foreach($aFilterArgs as $pgFilterKey => $pgFilterValue) {
					$this->passedArgs[$pgFilterKey] = $pgFilterKey.':'.$pgFilterValue;
				}
			}
			if (isset($filterURL) && $filterURL) {
				$this->passedArgs['?'] = $filterURL;
			}
	
			$paginator->options(array('url' => $this->passedArgs));
		}
		
?>
<div class="pagination">
    <? __('Pages');?>:
    <?=$paginator->prev(__('Previous', true), array('escape' => false))?>
    <?=$paginator->numbers()?>
    <?=$paginator->next(__('Next', true), array('escape' => false))?>
</div>
<?
	}
?>