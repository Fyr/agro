<?
class AjaxController extends TagsAppController {
	var $name = 'Ajax';
	var $layout = 'empty';
	var $uses = array('tags.Tag', 'tags.TagObject');
	
	function add() {
		$data = array('title' => $this->data['tag']);
		$this->Tag->save($data);
		$this->set('object_type', $this->data['object_type']);
		$this->set('object_id', $this->data['object_id']);
		$this->set('aTags', $this->Tag->getOptions());
		$this->set('aRelatedTags', $this->TagObject->getRelatedTags($this->data['object_type'], $this->data['object_id']));
	}
	
	function bind() {
		$this->TagObject->saveTag($this->data);
		exit;
	}
	
	function del() {
		$this->Tag->delete($this->data['tagID']);
		$this->TagObject->deleteAll(array('tag_id' => $this->data['tagID']));
		
		$this->set('object_type', $this->data['object_type']);
		$this->set('object_id', $this->data['object_id']);
		$this->set('aTags', $this->Tag->getOptions());
		$this->set('aRelatedTags', $this->TagObject->getRelatedTags($this->data['object_type'], $this->data['object_id']));
	}
}
