<?
	// Do not work from layout only - bug :(
	// $this->Html->css('/ddaccordion/css/ddaccordion', null, array('inline' => false));
	// $this->Html->script('/ddaccordion/js/ddaccordion', array('inline' => false));
?>

<div class="ddnMenu">
	<div class="ddnHeader"><a href="#"><? __('News');?></a></div>
	<div class="ddnSubmenu">
		<a class="first" href="/admin/articlesList/Article.object_type:CategoryNews"><? __('View list');?></a>
		<a href="/admin/articlesEdit/Article.object_type:CategoryNews"><? __('Add news item');?></a>
	</div>
	<div class="ddnHeader"><a href="#"><? __('Articles');?></a></div>
	<div class="ddnSubmenu">
		<a class="first" href="/admin/articlesList/Article.object_type:CategoryArticle"><? __('View list');?></a>
		<a href="/admin/articlesEdit/Article.object_type:CategoryArticle"><? __('Add article');?></a>
	</div>
	<div class="ddnHeader"><a href="http://www.javascriptkit.com">Test Grid</a></div>
	<div class="ddnSubmenu">
		<a class="first" href="/admin/newsList">View list</a>
	</div>
	<div class="ddnHeader"><a href="http://www.cssdrive.com">menu 4</a></div>
		<div class="ddnSubmenu">
		Some random content here<br />
		<div class="lorem"></div>
		</div>
	<div class="ddnHeader"><a href="http://www.codingforums.com">Menu 5</a></div>
		<div class="ddnSubmenu">
		Some random content here<br />
	</div>		
</div>

<script type="text/javascript">
<?
	// do not call from $(document).ready function - not works !!!
?>
ddaccordion.init({
	headerclass: "ddnHeader", //Shared CSS class name of headers group
	contentclass: "ddnSubmenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 0, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: false, //Collapse previous content (so only one open at any time)? true/false
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", "ddnSelected"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ['prefix', '<' + 'img src="/ddaccordion/img/expand.gif" alt="" />', '<' + 'img src="/ddaccordion/img/collapse.gif" alt="" />'], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "normal", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
$('#aaa').click(function(){ window.location = '/admin/news/'});
</script>
