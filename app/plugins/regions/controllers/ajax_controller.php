<?php
class AjaxController extends RegionsAppController {
	var $name = 'Ajax';
	var $layout = 'empty';
	var $uses = 'regions.Region';

	function subregionOptions($region_id) {
		$this->set('aSubregions', $this->Region->find('all', array(
			'conditions' => array('parent_id' => $region_id)
		)));
	}
	
}
?>
