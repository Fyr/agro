<?
	$this->PHCore->js('contacts');
?>
<div class="area mapContainer">
	<?=$this->element('title', array('title' => $aArticle2['Article']['title']))?>
	<?=$this->HtmlArticle->fulltext($aArticle2['Article']['body'])?>
</div>
<div class="area mapContainer">
	<?=$this->element('title', array('title' => $aArticle['Article']['title']))?>
	<?=$this->HtmlArticle->fulltext($aArticle['Article']['body'])?>
</div>
<div class="area">
	<?=$this->element('title', array('title' => 'Отправить сообщение'))?>
</div>
<form id="postForm" action="" method="post">
<div>
Вы можете отправить нам сообщение.<br/>
Поля, помеченные знаком <span class="required">*</span>, обязательны для заполнения.<br/>
</div>
<div class="section">
	<div class="s-frame">
		<div class="block one">
			<div class="error"><?=$errMsg?></div>
			<table class="pad5" border="0" cellpadding="0" cellspacing="0">
			<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Your name', true), 'required' => true, 'field' => 'Contact.username', 'data' => $this->data))?>
			<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Your e-mail for reply', true), 'required' => true, 'field' => 'Contact.email', 'data' => $this->data))?>
			<tr>
				<td colspan="2">
					<span class="required">*</span> Текст сообщения:<br/>
					<textarea cols="46" rows="5" name="data[Contact][body]"><?=$this->PHA->read($data, 'Contact.body')?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?=$this->element('captcha_img', array('plugin' => 'captcha', 'field'=> 'Contact.captcha', 'captcha_key' => $captchaKey, 'aErrFields' => $aErrFields))?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?=$this->element('button', array('caption' => 'Send', 'onclick' => 'document.postForm.submit();'))?>
				</td>
			</tr>
			</table>
		</div>
	</div>
</div>
<div>
<input type="hidden" name="data[send]" value="1" />
</div>
</form>
