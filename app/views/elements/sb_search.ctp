					<form id="searchForm" name="searchForm" action="/products/index/" method="get">
						<div class="label">Номер или название:</div>
						<div>
							<input type="text" name="data[filter][Article.title]" value="<?=$this->PHA->read($aFilter, 'Article\.title')?>" />
						</div>
						<div><br/></div>
						<div class="label"><?__('Brand')?>:</div>
						<div>
						<select name="data[filter][Article.brand_id]">
							<option value="">- <?__('All brands')?> -</option>
<?
	$options = array();
	foreach($aBrandTypes as $article) {
		$id = $article['Article']['id'];
		$title = $article['Article']['title'];
		$options[$id] = $title;
	}
	echo $this->element('options', array('plugin' => 'core', 'options' => $options, 'selected' => $this->PHA->read($aFilters, 'Article\.brand_id')));
?>
						</select>
						</div>
						<div><br/></div>
						<div class="label"><?__('Type')?>:</div>
						<div>
						<select class="autocompleteOff" name="data[filter][Article.subcat_id]">
							<option value="">- <?__('All types')?> -</option>
<?
	echo $this->element('choose_type', array('aTypes' => $aTypes, 'selected' => ''));
?>
						</select>
						</div>
						<div><br/></div>
<?
	/* if ($aTags) {
?>
						<div class="label"><?__('Category')?>:</div>
						<div>
						<select class="autocompleteOff" name="data[filter][Tag.id]" multiple="multiple" size="3" style="height: auto">
							<!-- option value="">- <?__('All categories')?> -</option -->
							<?=$this->element('options', array('plugin' => 'core', 'options' => $aTags, 'selected' => $this->PHA->read($aFilter, 'Tag\.id')));?>
						</select>
						</div>
<?
	}*/
?>
						<div class="clear"></div>
						<div class="submit-wrapper">
							<?=$this->element('button', array('caption' => __('Search', true), 'onclick' => 'document.searchForm.submit()'))?>
						</div>
					</form>
