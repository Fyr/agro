<?
class AjaxController extends MediaAppController {
	var $name = 'Ajax';
	var $layout = 'empty';
	var $uses = array('media.Media');
	
	function del($id) {
		$row = $this->Media->findById($id);
		$this->Media->delete($id);
		
		$this->Media->initMain($row['Media']['object_type'], $row['Media']['object_id'], $row['Media']['media_type']);
		exit;
	}
	
	function setMain($id) {
		/*
		$media = $this->Media->findById($id);
		if ($media) {
			$conditions = array('object_type' => $media['Media']['object_type'], 'object_id' => $media['Media']['object_id'], 'media_type' => $media['Media']['media_type']);
			$this->Media->updateAll(array('main' => 0), $conditions);
			
			$data = array('id' => $id, 'main' => 1);
			$this->Media->save($data);
			
			
			
			$this->Media->setMain()
		}
		*/
		$this->Media->setMain($id);
		exit;
	}
}
