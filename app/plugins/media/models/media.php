<?
class Media extends AppModel
{
    var $name = 'Media';

    public $stats = array('files' => 0, 'filesize' => 0);

    /*
    function getImage($id, $size) {
    	App::import('Vendor', 'Image', array('file' => 'image.class.php'));
		$image = new Image();

		$media = $this->Media->findById($id);
		$aSize = explode('x', $size);

		$image->load($this->Media->getFileName($media));
		$image->resize(intval($aSize[0]), intval($aSize[1]));
		$image->outputJpg();
    }
    */
    /*
		Stores file if it have been uploaded
			$data[inputName] - name of input control for file
			$data[makeThumb] - flag to create thumbnail, if set:
    		$data[thumbX] - set width of thumbnail, by default - 55px
    		$data[thumbY] - set height of thumbnail, be default - 75px
    		$data[thumbBkg] - set background color, by default - #ffffff

    */
    function saveMedia($data) {
    		if (!isset($data['object_type']) || !isset($data['object_id'])) {
				trigger_error('You must set "object_type" & "object_id"');
			}

			// Check if array of files was submitted
			$aFiles = array();
			if (isset($_FILES[$data['inputName']]['name'][0])) {
				foreach($_FILES[$data['inputName']] as $property => $aValues) {
					foreach($aValues as $key => $value) {
						$aFiles[$key][$data['inputName']][$property] = $value;
					}
				}
			} else {
				$aFiles = array($_FILES);
			}

			$objectType = strtolower($data['object_type']);

			App::import('Helper', 'media.PHMedia');
			$this->PHMedia = new PHMediaHelper();
			foreach($aFiles as $k => $_file) {
				$this->create();
				$data['media_type'] = $data['MediaType'][$k];
				$_ret = parent::save($data);
				$id = $this->id;

				$_FILES = $_file;
				$path = $this->PHMedia->getPath($objectType, $id); // PATH_FILES_UPLOAD.strtolower($data['object_type']).'/';
				if ($data['media_type'] == 'image') {
					$justName = $data['media_type'];
				} else {
					$justName = '';
				}
				$justExt = '';

				if (!file_exists($path)) {
					if (!file_exists($this->PHMedia->getPagePath($objectType, $id))) {
						mkdir($this->PHMedia->getPagePath($objectType, $id), 0755);
					}
					mkdir($path, 0755);
				}

				$newFName = $this->uploadFile($data['inputName'], $path, &$justName, &$justExt);
				$aSave = array('id' => $id, 'file' => $justName, 'ext' => $justExt);
				
				// Save orig file size
				$file = $this->PHMedia->getFileName($objectType, $id, null, $justName.$justExt);
				$aSave['orig_fsize'] = filesize($file);
				
				if ($data['media_type'] == 'image') {
					// Save original image resolution
					App::import('Vendor', 'Image', array('file' => '../plugins/media/vendors/image.class.php'));
					$image = new Image();
					$image->load($file);
					$aSave['orig_w'] = $image->getSizeX();
					$aSave['orig_h'] = $image->getSizeY();
				}
				
				$_ret = $_ret && parent::save($aSave);

			}
    }

    function save($data) {
    	$_ret = true;

		if (isset($data['Media'])) {
			$data = $data['Media'];
		}

		if (isset($data['inputName']['name']) && isset($_FILES[$data['inputName']]['name']) && $_FILES[$data['inputName']]['name']) {
			$_ret = $this->saveMedia($data);
		} else {
			$_ret = parent::save($data);
		}
		return $_ret;
	}

	function beforeDelete() {
		App::import('Vendor', 'path', array('file' => '../plugins/core/vendors/path.php'));

		App::import('Helper', 'media.PHMedia');
		$this->PHMedia = new PHMediaHelper();

		$row = $this->findById($this->id);
		$this->initMain($row['Media']['object_type'], $row['Media']['object_id'], $row['Media']['media_type']);

		$path = $this->PHMedia->getPath($row['Media']['object_type'], $this->id);

		if (file_exists($path)) {
			$aPath = getPathContent($path);
			if (isset($aPath['files']) && $aPath['files']) {
				foreach($aPath['files'] as $file) {
					unlink($aPath['path'].$file);
				}
			}
			rmdir($path);
		}
		return true;
	}

	function initMain($objectType, $objectID, $mediaType = null) {
		$aMediaTypes = ($mediaType) ? array($mediaType) : array('image','video','audio','raw_file');
		foreach($aMediaTypes as $media_type) {
			$mainMedia = $this->getMain($objectType, $objectID, $media_type);
			if ($mainMedia && !$mainMedia['Media']['main']) {
				$data = $mainMedia;
				$data['Media']['main'] = 1;
				$this->save($data);
			}
		}
	}

	function setMain($id, $objectType = null, $objectID = null, $mediaType = null) {
		if (!$objectType|| !$objectID || !$mediaType) {
			$media = $this->findById($id);
			$objectType = $media['Media']['object_type'];
			$objectID = $media['Media']['object_id'];
			$mediaType = $media['Media']['media_type'];
		}
		$conditions = array('object_type' => $objectType, 'object_id' => $objectID, 'media_type' => $mediaType);
		$this->updateAll(array('main' => 0), $conditions);

		$data = array('id' => $id, 'main' => 1);
		$this->save($data);
	}

	function getMain($objectType, $objectID, $mediaType) {
		return $this->find('first', array(
				'conditions' => array('media_type' => $mediaType, 'object_type' => $objectType, 'object_id' => $objectID),
				'order' => array('main DESC', 'id')
			));
	}

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

	public function removeImageFiles($fname, $path) {
		$info = pathinfo($fname);
		if ($info['filename'] !== 'image') {
			$this->stats['files']++;
			$this->stats['filesize']+= filesize($path.$fname);
			@unlink($path.$fname);
		}
	}

	function removeImageCache() {
		App::import('Vendor', 'noclass', array('file' => '../plugins/core/vendors/path.php'));
		processPath(getPathContent(PATH_FILES_UPLOAD.'article/'), array($this, 'removeImageFiles'), true);
		return $this->stats;
	}
	
	function relocateMedia($oldObjType, $oldObjID, $newObjType, $newObjID) {
		App::import('Helper', 'media.PHMedia');
		$this->PHMedia = new PHMediaHelper();
		
		$conditions = array('object_type' => $oldObjType, 'object_id' => $oldObjID);
		$aMedia = $this->find('all', compact('conditions'));
		foreach($aMedia as $_media) {
			$media = $_media['Media'];
			$path['src'] = $this->PHMedia->getPath(strtolower($media['object_type']), $media['id']);
			$path['dst'] = $this->PHMedia->getPath(strtolower($newObjType), $media['id']);
			if (!file_exists($path['dst'])) {
				$subpath = $this->PHMedia->getPagePath(strtolower($newObjType), $media['id']);
				if (!file_exists($subpath)) {
					mkdir($subpath, 0755);
				}
				mkdir($path['dst'], 0755);
			}
			rename($path['src'].$media['file'].$media['ext'], $path['dst'].$media['file'].$media['ext']);
			$this->save(array('id' => $media['id'], 'object_type' => $newObjType, 'object_id' => $newObjID));
			rmdir($path['src']);
			
			$this->stats['files']++;
		}
	}
}
