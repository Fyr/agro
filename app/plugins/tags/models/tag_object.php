<?
class TagObject extends TagsAppModel {
	var $name = 'TagObject';
	// var $useTable = 'tags';
	
	function saveTag($data) {
		if ($data['set']) {
			$res = $this->find('first', 
				array('conditions' => array('object_type' => $data['object_type'], 'object_id' => $data['object_id'], 'tag_id' => $data['tag_id']))
			);
			if (!$res) {
				$this->save($data);
			}
		} else {
			$this->deleteAll(array('object_type' => $data['object_type'], 'object_id' => $data['object_id'], 'tag_id' => $data['tag_id']));
		}
	}
	
	function getRelatedTags($object_type, $object_id) {
		$aRows = $this->find('all', array(
			'conditions' => array('object_type' => $object_type, 'object_id' => $object_id)
		));
		$aTags = array();
		foreach($aRows as $row) {
			$aTags[] = $row['TagObject']['tag_id'];
		}
		return $aTags;
	}
	
	function getRelatedObjects($aTags, $exceptObj = null, $limit = null) {
		$aParams = array(
			'fields' => array('object_type', 'object_id', 'COUNT(*) as count'),
			'conditions' => array('tag_id' => $aTags),
			'group' => array('object_type', 'object_id'),
			'order' => 'count DESC'
		);
		if ($exceptObj) {
			$aParams['conditions']['NOT'] = array(array('object_type' => $exceptObj['object_type'], 'object_id' => $exceptObj['object_id']));
		}
		if ($limit) {
			$aParams['limit'] = $limit;
		}
		$_ret = $this->find('all', $aParams);
		return $_ret;
	}
}
