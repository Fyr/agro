<?
define('ERR_1', __('This field should not be blank', true));
define('ERR_2', __('Username length should be between 3 to 50 characters', true));
define('ERR_3', __('Password should be mimimum 6 characters long', true));
define('ERR_5', __('Incorrect e-mail address', true));
define('ERR_7', __('Incorrect text for image', true));

class Comment extends CommentsAppModel {
	var $name = 'Comment';
	var $useTable = 'comments';
	// var $alias = 'Comment';
	
	var $validate = array(
		'username' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => ERR_1
			),
			'between' => array(
				'rule' => array('between', 3, 50),
				'message' => ERR_2
			)
		),
		'email' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => ERR_1
			),
			'email' => array(
				'rule' => 'email',
				'message' => ERR_5
			)
		),
		'body' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => ERR_1
			)
		),
		'captcha' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => ERR_1
			),
			'check_captcha' => array(
				'rule' => array('checkCaptcha'),
				'message' => ERR_7
			)
		)
	);
	
	function checkCaptcha($value) {
		return (substr(md5(_SALT.$this->data['Comment']['captcha_q']), 0, 6) === $this->data['Comment']['captcha']);
	}
	
	function publish($aID, $lPublish = true) {
		$this->updateAll(array('published' => $lPublish), array('id' => $aID));
	}
}