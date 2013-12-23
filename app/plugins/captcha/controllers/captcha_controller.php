<?
class CaptchaController extends CaptchaAppController {
	var $name = 'Captcha';
	var $uses = array();

	function index($captchaKey = '') {
		App::import('Vendor', 'captcha', array('file' => '../plugins/captcha/vendors/captcha.class.php'));
		$captcha = new captcha(substr(md5(_SALT.$captchaKey), 0, 6));
		exit;
	}
}
