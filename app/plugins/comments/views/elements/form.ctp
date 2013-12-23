<?
/**
 * Params:
 * // (bool) authorized - is user authorizdd. Affects on required fields
 */
	if (!isset($allowGuest)) {
		$allowGuest = false;
	}
?>
<a name="comment_form"></a>
<h1><? __('Post your comment');?></h1>
Fields marked with <span class="required">*</span> are required. Your E-mail will be NOT published.<br/>
<form id="postForm" name="postForm" action="#comment_form" method="post">
<table width="100%" class="pad5" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width="30%"></td>
	<td></td>
</tr>
<?
	if ($allowGuest) {
?>		
		<?=$this->element('std_input', array('plugin' => 'core', 'data' => $this->data, 'caption' => __('User name', true), 'field' => 'Comment.username', 'aErrFields' => $aErrFields, 'required' => true))?>
		<?=$this->element('std_input', array('plugin' => 'core', 'data' => $this->data, 'caption' => __('Your email for reply', true), 'field' => 'Comment.email', 'aErrFields' => $aErrFields, 'required' => true))?>
<?
	}
?>
<tr>
	<td colspan="2">
		<span class="required">*</span> Message text:<br/>
		<!--
		<textarea cols="46" rows="5" name="data[Comment][body]"><?=$this->PHA->read($this->data, 'Comment.body')?></textarea>
		-->
		<div class="comments">
			<div class="comment_write_box">
<?
	$comment = $this->PHA->read($this->data, 'Comment.body');
?>
				<div class="comment_write" onclick="onCommentTextFocus()"><span>Комментировать...</span>
					<textarea rows="5" cols="40" name="data[Comment][body]"><?=($comment) ? $comment : ''?></textarea>
<script type="text/javascript">
<?
	if ($comment) {
?>
$(document).ready(function(){
	onCommentTextFocus();
});
<?
	}
?>
function onCommentTextFocus() {
	$('.comments .comment_write_box span').hide(); 
	$('.comments .comment_write_box textarea').css('display', 'block').focus();
}
</script>
				</div>
			</div>
		</div>
<?
	if (isset($aErrFields['Comment']['body'])) {
?>
		<span class="errNote"><?=$aErrFields['Comment']['body']?></span>
<?
	}
?>
	</td>
</tr>
</table>
<?
	if ($allowGuest) {
?>
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td colspan="2" nowrap="nowrap">
		<?=$this->element('captcha_img', array('plugin' => 'captcha', 'field' => 'Comment.captcha'))?>
	</td>
</tr>
<tr>
	<td colspan="2">
		<div style="height: 20px; margin-top: 10px;">
			<?=$this->element('btn_icon_save', array('plugin' => 'core', 'onclick' => 'document.postForm.submit()', 'title' => __('Post comment', true)))?>
		</div>
	</td>
</tr>
</table>
<?
	}
?>
</form>
