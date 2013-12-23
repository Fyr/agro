<?
class Contact extends AppModel {
	var $name = 'Contact';
	var $useTable = false;
	
	var $validate = array(
		'username' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Username cannot be blank'
			),
			'between' => array(
				'rule' => array('between', 3, 50),
				'message' => 'Username length should be between 3 to 50 characters'
			)
		),
		'email' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Username cannot be blank'
			),
			'email' => array(
				'rule' => 'email',
				'message' => 'Incorrect e-mail address'
			)
		),
		'captcha' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Text for captcha cannot be blank'
			),
			'check_captcha' => array(
				'rule' => array('checkCaptcha'),
				'message' => 'Incorrect text for image'
			)
		)
	);
	
	function checkCaptcha($value) {
		return (substr(md5(_SALT.$this->data['User']['captcha_q']), 0, 6) === $this->data['User']['captcha']);
	}

}
