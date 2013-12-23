<?
class AdminAjaxController extends AppController {
	var $name = 'AdminAjax';
	var $layout = 'empty';
	// var $components = array('articles.PCArticle');
	
	var $uses = array('params.Param', 'params.ParamObject', 'params.ParamValue');

	function categoriesUpdate() {
		// file_put_contents('tmp_cu.log', print_r($_GET, true));
		echo 'OK';
		exit();
	}
	
	function categoriesDelete() {
		// file_put_contents('tmp_cd.log', print_r($_GET, true));
		echo 'OK';
		exit();
	}
	
	function getTechParams($typeID, $id = 0) {
		$aParams = $this->Param->getParams($this->ParamObject->getBinded('ProductParam', $typeID));
		$aParamValues = $this->ParamValue->getValues('ProductParam', $id);
		
		$this->set('aParams', $aParams);
		$this->set('aParamValues', $aParamValues);
	}
}