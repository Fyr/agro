<?
class SiteEmailComponent extends EmailComponent {
	
	function send($content = null, $template = null, $layout = null) {
		if (TEST_ENV) {
			$this->delivery = 'debug';
		}
		return parent::send($content, $template, $layout);
	}
	
	// Used to send emails to users
	function sendTo($email, $template, $subj, $layout = 'default') {
		$this->template = $template;
		$this->layout = $layout;
		
		$this->to = $email;
		if (defined('EMAIL_ADMIN_CC')) {
			$this->bcc = array(EMAIL_ADMIN_CC);
		}
		$this->subject = $subj;
		$this->replyTo = 'noreply@'.DOMAIN_NAME;
		$this->from = 'info@'.DOMAIN_NAME;
		$this->sendAs = 'html';
		
		$_return = $this->send();
		
		// parent::reset();
		
		return $_return;
	}

	// Used to send notifications to admin
	function notifyAdmin($template, $subj) {
		return $this->sendTo(EMAIL_ADMIN, 'admin'.DS.$template, $subj);
	}

	function _debug() {
		$nl = "\r\n";
		$header = implode($nl, $this->__header);
		$message = implode($nl, $this->__message);
		$fm = '';

		if ($this->delivery == 'smtp') {
			$fm .= sprintf('%s %s%s', 'Host:', $this->smtpOptions['host'], $nl);
			$fm .= sprintf('%s %s%s', 'Port:', $this->smtpOptions['port'], $nl);
			$fm .= sprintf('%s %s%s', 'Timeout:', $this->smtpOptions['timeout'], $nl);
		}
		$fm .= sprintf('%s %s%s', 'To:', $this->to, $nl);
		$fm .= sprintf('%s %s%s', 'From:', $this->from, $nl);
		$fm .= sprintf('%s %s%s', 'Subject:', mb_convert_encoding($this->subject, "CP1251", "UTF-8"), $nl);
		$fm .= sprintf('%s%3$s%3$s%s', 'Header:', $header, $nl);
		$fm .= sprintf('%s%3$s%3$s%s', 'Parameters:', $this->additionalParams, $nl);
		$fm .= sprintf('%s%3$s%3$s%s', 'Message:', mb_convert_encoding($message, "CP1251", "UTF-8"), $nl);
		$fm .= $nl.'-----------------------------------------'.$nl;
		// $text = print_r(array('header' => $this->__header, 'message' => "\r\n".mb_convert_encoding(implode("\r\n", $this->__message), "CP1251", "UTF-8")), true);
		file_put_contents('email.log', $fm, FILE_APPEND);
		return true;
	}
	
	function _render($content) {
		$viewClass = $this->Controller->view;

		if ($viewClass != 'View') {
			list($plugin, $viewClass) = pluginSplit($viewClass);
			$viewClass = $viewClass . 'View';
			App::import('View', $this->Controller->view);
		}

		$View = new $viewClass($this->Controller, false);
		$View->layout = $this->layout;
		$msg = array();

		$content = implode("\n", $content);

		if (!empty($this->attachments)) {
			if ($this->sendAs === 'html') {
				$msg[] = '';
				$msg[] = '--' . $this->__boundary;
				$msg[] = 'Content-Type: text/html; charset=' . $this->charset;
				$msg[] = 'Content-Transfer-Encoding: 7bit';
				$msg[] = '';
			} else {
				$msg[] = '--' . $this->__boundary;
				$msg[] = 'Content-Type: text/plain; charset=' . $this->charset;
				$msg[] = 'Content-Transfer-Encoding: 7bit';
				$msg[] = '';
			}
		}

		$content = $View->render(DS.'email'.DS.$this->template, 'email'.DS.$this->layout);
		$content = explode("\n", $rendered = str_replace(array("\r\n", "\r"), "\n", $content));

		$this->htmlMessage = $rendered;

		$msg = array_merge($msg, $content);

		return $msg;
	}
	
}
?>