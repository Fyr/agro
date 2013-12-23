<?
define('ERR_11', __('This field should not be blank', true));
define('ERR_12', __('Username length should be between 3 to 50 characters', true));
define('ERR_14', __('User with such email already exists', true));

class UserProfile extends UsersAppModel {
	var $name = 'User';
	var $useTable = 'users';
	
	var $hasOne = array(
		'Media' => array(
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Avatar'),
			'dependent' => true
		)
	);
	//var $validate = array(
	/*
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
	*/
	/*
		'email' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => ERR_1
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => ERR_4
			),
			'email' => array(
				'rule' => 'email',
				'message' => ERR_5
			)
		),
	*/
	// );
	function saveAll($data) {
		fdebug($_FILES, 'tmp2.log');
		fdebug($data, 'tmp3.log');
		parent::saveAll($data);
	}
}
?>