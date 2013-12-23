<?
class PHGridHelper extends AppHelper {
	var $helpers = array('Html', 'Text', 'Time', 'core.PHTime');
	
	function render($model, $actions = null, $render = null) {
		$view = &ClassRegistry::getObject('view');
		$aParams = array('plugin' => 'grid', 'model' => $model);
		if ($actions) {
			$aParams['actions'] = $actions;
		}
		if ($render) {
			$aParams['render'] = $render;
		}
		return $view->element('grid_render', $aParams);
	}
	
	function renderEdit($model) {
		$view = &ClassRegistry::getObject('view');
		$aParams = array('plugin' => 'grid', 'model' => $model);
		return $view->element('grid_edit', $aParams);
	}
	
	function backUrl() {
		return '/'.$this->params['url']['url'];
	}
	
	function _denormalizeField($field) {
		$aInfo = explode('.', $field);
		return array('model' => $aInfo[0], 'field' => $aInfo[1]);
	}
}