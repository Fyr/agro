<?php
class AjaxController extends CategoryAppController {

	var $name = 'Ajax';
	var $layout = 'empty';
	var $uses = 'category.Category';

	function submit() {
		// check if such category already exists
		$this->data['Category']['featured'] = (isset($this->data['Category']['featured'])) ? $this->data['Category']['featured'] : '0';
		$this->Category->save($this->data);
		$this->set('aCategoryOptions', $this->Category->getOptions($this->data['Category']['object_type']));
	}
	
	function del($id) {
		$aRow = $this->Category->findById($id);
		$this->Category->delete($id);
		$this->set('aCategoryOptions', $this->Category->getOptions($aRow['Category']['object_type']));
		// exit('Error:'.'Удалить данную категорию можно только после удаления в ней всех статей');
	}
}
?>
