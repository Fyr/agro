<?php
class PCCaptchaComponent extends Object {
	
	// called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		$captchaKey = md5(_SALT.mt_rand()); // any random text
		$controller->set('captchaKey', $captchaKey);
	}
}
