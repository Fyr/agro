<?
class PHTimeHelper extends TimeHelper {
	function niceShort($dateString = null, $userOffset = null) {
		$ret = parent::niceShort($dateString, $userOffset);
		
		$aReplaceENG = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jul', 'Jun', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
		$aReplace = array(__('Jan', true), __('Feb', true), __('Mar', true), __('Apr', true), __('May', true), __('Jul', true), __('Jun', true), __('Aug', true), __('Sep', true), __('Oct', true), __('Nov', true), __('Dec', true));
		return str_replace(array('st', 'nd', 'th'), '', str_replace($aReplaceENG, $aReplace, $ret));
	}
}