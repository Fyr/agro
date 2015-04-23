<?
class ContactsController extends SiteController {
	var $components = array('Email', 'SiteEmail');
	var $helpers = array('core.PHA', 'core.PHCore', 'Time', 'core.PHTime', 'articles.HtmlArticle');
	var $uses = array('articles.Article', 'SitePage', 'Contact');
	
	function index() {
		$this->aBreadCrumbs = array('/' => 'Home', 'Contacts');
		$captchaKey = md5(_SALT.mt_rand()); // any random text

		if (isset($this->data['send'])) {
			if (!$this->data['Contact']['username']) {
				$this->errMsg[] = __('Input your name', true);
			} 
			if (!$this->data['Contact']['email']) {
				$this->errMsg[] = __('Input your email address', true);
			} elseif (!AppModel::isEmailValid($this->data['Contact']['email'])) {
				$this->errMsg[] = __('Incorrect email address', true);
			} 
			if (!$this->data['Contact']['body']) {
				$this->errMsg[] = __('Input the message', true);
			}
			if (substr(md5(_SALT.$this->data['Contact']['captcha_q']), 0, 6) !== $this->data['Contact']['captcha']) {
				$this->errMsg[] = __('Incorrect text on image', true);
			}
			
			if (!$this->errMsg) {
			// if ($this->Contact->validates()) {
				$this->SiteEmail->to = EMAIL_ADMIN;
			    $this->SiteEmail->subject = 'A message from '.DOMAIN_NAME;
			    $this->SiteEmail->replyTo = $this->data['Contact']['email'];
			    $this->SiteEmail->from = $this->data['Contact']['email'];
			    $this->SiteEmail->template = 'contact_us';
			    $this->SiteEmail->sendAs = 'html';

			    $this->data['Contact']['body'] = nl2br(str_replace(array('<', '>'), array('&lt;', '&gt;'), $this->data['Contact']['body']));
			    $this->set('data', $this->data);

			    $this->SiteEmail->send();

				$this->redirect('/contacts/success');
				exit;
			} else {
				$this->aErrFields = $this->Contact->invalidFields();
			}
				
		}

		$this->set('aArticle', $this->SitePage->findByPageId('contacts1'));
		$this->set('aArticle2', $this->SitePage->findByPageId('contacts2'));
		$this->set('data', $this->data);
		$this->set('captchaKey', $captchaKey);
		
		$this->disableCopy = false;
	}

	function success() {
		$this->page_title = 'Контакты';
	}

	function view($id) {
		$aArticle = $this->Brand->findById($id);
		$aArticle['Article'] = $aArticle['Brand'];
		$this->set('aArticle', $aArticle);
		
		$this->pageTitle = (isset($aArticle['Seo']['title']) && $aArticle['Seo']['title']) ? $aArticle['Seo']['title'] : $aArticle['Article']['title'];
		$this->data['SEO'] = $aArticle['Seo'];
		
		$this->aBreadCrumbs = array('/' => 'Home', '/brands/' => 'Brands', 'View brand');
	}
}
