<?
class RouterController extends MediaAppController {
	var $name = 'Router';
	var $layout = 'empty';
	var $uses = array('media.Media', 'Article');

	function index($type, $id, $size, $filename) {
		App::import('Helper', 'media.PHMedia');
		$this->PHMedia = new PHMediaHelper();

		$aFName = $this->PHMedia->getFileInfo($filename);
		$fname = $this->PHMedia->getFileName($type, $id, $size, $filename);
		if ($type == 'product') {
			list($domain, $zone) = explode('.', DOMAIN_NAME);
			$fname = str_replace('.'.$aFName['ext'], '_'.$zone.'.'.$aFName['ext'], $fname);
		}
		
		if (file_exists($fname)) {
			header('Content-type: image/'.$aFName['ext']);
			echo file_get_contents($fname);
			exit;
		}

		$aSize = $this->PHMedia->getSizeInfo($size);

		App::import('Vendor', 'Image', array('file' => '../plugins/media/vendors/image.class.php'));
		$image = new Image();
		$img_file = $this->PHMedia->getFileName($type, $id, null, $aFName['orig_fname'].'.'.$aFName['orig_ext']);
		$image->load($img_file);

		if ($aSize) {
			$image->resize($aSize['w'], $aSize['h']);
		}

		// Put watermark
		// $media = $this->Media->findById($id);
		// $article = $this->Article->findById($media['Media']['object_id']);
		// if ($article['Article']['object_type'] == 'products') {
		if ($type == 'product') {

			$logo = new Image();
			$logo->load('./img/logo.gif');

			// т.к. есть баг с ресайзом лого (при ресайзе исчезает прозрачность и появляется фон),
			// то ресайзим саму картинку, а потом возвращаем ее в исх. размер или ресайзим в нужный
			$oldSizeX = $image->getSizeX();
			$oldSizeY = $image->getSizeY();
			$lRestoreSize = false;
			if ($aSize) {
				if ($logo->getSizeX() > $image->getSizeX()) {
					$image->resize($logo->getSizeX(), null);
					$lRestoreSize = true;
				}
			} elseif ($image->getSizeX() > 400) {
				$logo->load('./img/logo.gif');
			}
			$x = round(($image->getSizeX()) / 2, 0) - round($logo->getSizeX() / 2, 0);
			$y = round(($image->getSizeY()) / 2, 0) - round($logo->getSizeY() / 2, 0);
			imagealphablending($image->getImage(), false);
			imagesavealpha($image->getImage(), true);
			imagecopymerge($image->getImage(), $logo->getImage(), $x, $y, 0, 0, $logo->getSizeX(), $logo->getSizeY(), 40);
			if ($lRestoreSize) {
				$image->resize($oldSizeX, null);
			}
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
