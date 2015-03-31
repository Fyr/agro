<?
class MediaProduct extends AppModel {
	var $name = 'MediaProduct';
	var $useTable = 'media_products';
	var $alias = 'Media';
	
	function getMedia($objectType, $id) {
		$media = $this->find('all', array(
				'conditions' => array('Media.object_type' => $objectType, 'Media.object_id' => $id)
		));
		$aItems = array();
		foreach($media as $row) {
			$aItems[] = $row['Media'];
		}
		return $aItems;
	}
}
