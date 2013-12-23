<?
define('FAQQA_1', __('This field should not be blank', true));
define('FAQQA_2', __('This field should be numeric', true));

class FaqQA extends FaqsAppModel {
	var $name = 'FaqQA';
	var $useTable = 'faqs_qa';
	
	var $validate = array(
		'q_text' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => FAQQA_1
			)
		),
		'a_text' => array(
			'nonEmpty' => array(
				'rule' => 'notEmpty',
				'message' => FAQQA_1
			)
		),
		'sort_order' => array(
			'decimal' => array(
				'rule' => array('numeric'),
				'message' => FAQQA_2
			)
		),
	);
	
	function getFaq($faq_id) {
		return $this->find('all', array(
			'conditions' => array('faq_id' => $faq_id, 'published' => 1),
			'order' => 'sort_order'
		));
	}
}