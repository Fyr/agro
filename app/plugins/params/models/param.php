<?
class Param extends ParamsAppModel {
	var $name = 'Param';
	var $useTable = 'params';

	const BOOL = 1;
	const INT = 2;
	const FLOAT = 3;
	const STRING = 4;
	const TEXT = 5;
	const DATE = 6;
	const TIME = 7;
	const OPTIONS = 8;

	function getOptions() {
		return array(
			self::BOOL => __('Boolean (yes|no)', true),
			self::INT => __('Integer', true),
			self::FLOAT => __('Float', true),
			self::STRING => __('String (text)', true),
			self::TEXT => __('Text (textarea)', true),
			self::DATE => __('Date', true),
			self::TIME => __('Time', true),
			self::OPTIONS => __('Dropdown menu list', true)
		);
	}

	function getParams($aParamID) {
		return $this->find('all', array('conditions' => array('id' => $aParamID)));
	}

	static function options($options) {
		$a = explode("<br />", nl2br($options));
		array_unshift($a, false);
		unset($a[0]);
		return $a;
	}
}
