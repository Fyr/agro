<?
	$this->PHCore->css(array('jquery.fancybox'));
	$this->PHCore->js(array('jquery.fancybox.pack.js')); 
?>
<style type="text/css">
iframe {width: 100%;}
</style>
<?=$this->element('title', array('title' => $aArticle['Article']['title']))?>
<div class="block main clearfix">
	<?=$this->HtmlArticle->fulltext($aArticle['Article']['body'])?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.block.main img').each(function(){
		$(this).wrap(function(){
			console.log(this);
			return '<a class="fancybox" href="' + this.src.replace(/150x/g, 'noresize') + '" rel="photoalobum"></a>';
		});
	});
	
	$('.fancybox').fancybox({
		padding: 5
	});
});
</script>