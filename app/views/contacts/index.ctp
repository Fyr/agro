<?=$this->element('title', array('title' => $aArticle2['Article']['title']))?>
<div class="block main">
	<?=$this->HtmlArticle->fulltext($aArticle2['Article']['body'])?>
</div>

<?=$this->element('title', array('title' => $aArticle['Article']['title']))?>
<div class="block main">
	<?=$this->HtmlArticle->fulltext($aArticle['Article']['body'])?>
</div>
<?=$this->element('title', array('title' => 'Отправить сообщение'))?>
<form method="post" action="" id="postForm">
	<div class="block main">
		<p>Вы можете отправить нам сообщение.<br>Поля, помеченные знаком <span class="required">*</span>, обязательны для заполнения.<br>
		</p>
		<div class="error"><?=$errMsg?></div>
		<div class="formItem">
			<div class="formName"><span class="required">*</span> Ваше имя</div>
			<div class="formField"><input type="text" id="Contact__username" name="data[Contact][username]" value="<?=$this->PHA->read($data, 'Contact.username')?>"></div>
		</div>
		<div class="formItem">
			<div class="formName"><span class="required">*</span> Ваш E-mail для ответа</div>
			<div class="formField"><input type="text" id="Contact__email" name="data[Contact][email]" value="<?=$this->PHA->read($data, 'Contact.email')?>"></div>
		</div>
		<div class="formItem">
			<span class="required">*</span> Текст сообщения:<br>
			<textarea name="data[Contact][body]" rows="5" cols="46"><?=$this->PHA->read($data, 'Contact.body')?></textarea>
		</div>
		<div class="formItem captcha clearfix">
			<?=$this->element('captcha_img', array('plugin' => 'captcha', 'field'=> 'Contact.captcha', 'captcha_key' => $captchaKey, 'aErrFields' => $aErrFields))?>
		</div>
		<div class="formItem">
			<input type="button" value="Отправить" onclick="document.postForm.submit();" class="submit">
			<input type="hidden" value="1" name="data[send]">
		</div>
	</div>
</form>
