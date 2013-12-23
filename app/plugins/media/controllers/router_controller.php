<?
class RouterController extends MediaAppController {
	var $name = 'Router';
	var $layout = 'empty';
	var $uses = array();

	function index($type, $id, $size, $filename) {
		App::import('Helper', 'media.PHMedia');
		$this->PHMedia = new PHMediaHelper();

		$fname = $this->PHMedia->getFileName($type, $id, $size, $filename);
		$aFName = $this->PHMedia->getFileInfo($filename);

		if (file_exists($fname)) {
			header('Content-type: image/'.$aFName['ext']);
			echo file_get_contents($fname);
			exit;
		}

		App::import('Vendor', 'Image', array('file' => '../plugins/media/vendors/image.class.php'));
		$image = new Image();

		$aSize = $this->PHMedia->getSizeInfo($size);

		$image->load($this->PHMedia->getFileName($type, $id, null, $aFName['fname'].'.'.$aFName['orig_ext']));
		if ($aSize) {
			$image->resize($aSize['w'], $aSize['h']);
		}
		if ($aFName['ext'] == 'jpg') {
			$image->outputJpg($fname);
			$image->outputJpg();
		} elseif ($aFName['ext'] == 'png') {
			$image->outputPng($fname);
			$image->outputPng();
		} else {
			$image->outputGif($fname);
			$image->outputGif();
		}
		exit;
	}
}
