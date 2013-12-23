<?
define('FAQ_1', __('This field should not be blank', true));

class Faq extends FaqsAppModel {
	var $name = 'Faq';
	var $useTable = 'faqs';
	
	var $validate = array(
		'title' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => FAQ_1
			)
		)
	);
}