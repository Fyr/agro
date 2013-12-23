<?
class PHFckeHelper extends Helper {
	var $helpers = Array('Html');

	function textarea($fieldName, $value, $toolbar = 'Default', $width = 550, $height = 300) {
		require_once WWW_ROOT.DS.'js'.DS.'fckeditor'.DS.'fckeditor.php';

		$oFCKeditor = new FCKeditor($fieldName) ;

		$oFCKeditor->BasePath = '/js/fckeditor/';
		$oFCKeditor->Value = $value;
		$oFCKeditor->Height = $height;
		$oFCKeditor->Width = $width;

		$oFCKeditor->ToolbarSet = $toolbar;

		$oFCKeditor->Create();
	}
}