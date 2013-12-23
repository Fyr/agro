<? __('You have received a new message from ').DOMAIN_TITLE?>:<br />
<? __('Username')?>: <?=$data['Contact']['username']?><br />
<? __('E-mail')?>: <a href="mailto:<?=$data['Contact']['email']?>"><?=$data['Contact']['email']?></a><br />
<br />
<? __('Message')?>:<br />
<span class="look">
<?=$data['Contact']['body']?>
</span>