<?
class AjaxController extends AppController {
	var $name = 'Ajax';
	var $layout = 'empty';
	var $components = array('grid.PCGrid');
	var $uses = array('comments.Comment');

	function moreComments($objectType, $objectID) {
		$this->grid['Comment'] = array(
			'conditions' => array('object_type' => 'Article', 'object_id' => $objectID, 'published' => 1),
			'order' => array('created' => 'desc'),
			'limit' => 2
		);
		$aComments = $this->PCGrid->paginate('Comment');
		$this->set('aComments', $aComments);
	}
}
