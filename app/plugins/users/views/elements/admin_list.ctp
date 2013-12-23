<?
	$this->Html->script(array('/core/js/jquery.cookie'), array('inline' => false));	
	$selected = $this->PHA->read($aArticleFilters, 'Article\.object_id');
?>
<form id="filterForm" action="" method="post" onsubmit="article_onSubmitFilter(); return false;">
<table class="pad5 adminTable" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr>
	<th>
		<?=$this->element('icon_action', array('plugin' => 'core', 'img' => 'process.png', 'onclick' => "article_onFilter()", 'title' => __('Show\Hide filter settings', true)))?>
	</th>
<!--	<th><?=$this->element('sort_field', array('plugin' => 'core', 'title' => __('Published', true), 'sortKey' => 'Article.published'))?></th> -->
	<th><?=$this->element('sort_field', array('plugin' => 'core', 'title' => __('Modified', true), 'sortKey' => 'Article.modified'))?></th>
	<th><?=$this->element('sort_field', array('plugin' => 'core', 'title' => __('Category', true), 'sortKey' => 'Article.object_id'))?></th>
	<th><?=$this->element('sort_field', array('plugin' => 'core', 'title' => __('Title', true), 'sortKey' => 'Article.title'))?></th>
</tr>
</thead>
<tbody>
<tr class="articleFilter hide">
	<td align="center">
		<?=$this->element('icon_action', array('plugin' => 'core', 'img' => 'process_accept.png', 'onclick' => "article_onSubmitFilter()", 'title' => __('Apply filter settings', true)))?>
		<?=$this->element('icon_action', array('plugin' => 'core', 'img' => 'process_remove.png', 'onclick' => "article_onClearFilter()", 'title' => __('Apply filter settings', true)))?>
	</td>
	<td></td>
	<td>
		<select id="Article__object_id" name="Article__object_id">
		<?=$this->element('category_options', array('plugin' => 'category', 'aCategoryOptions' => $aCategoryOptions, 'selected' => $selected))?>
		</select>
	</td>
	<td>
		<input type="text" id="Article__title" name="Article__title" value="<?=$this->PHA->read($aArticleFilters, 'Article\.title')?>" />
	</td>
</tr>
<?
	$class = '';
	foreach ($aArticles as $article) {
		$class = ($class) ? '' : ' class="row2"';
		$id = $article['Article']['id'];
?>

<tr<?=$class?>>
	<td>
<?
	/*
		foreach($aActions as $element => $aParams) {
?>

		<?=$this->element($element, $aParams)?>
<?
		}
	*/
?>

		<?=$this->element('icon_edit', array('plugin' => 'core', 'href' => '/admin/articlesEdit/'.$id))?>
		<?=$this->element('icon_del', array('plugin' => 'core', 'href' => '/admin/articlesDel/'.$id))?>
		<?=$this->element('icon_info', array('plugin' => 'core', 'title' => $article['Article']['body']))?>
	</td>
<!--	<td><?=$article['Article']['published']?></td> -->
	<td><?=$this->PHTime->niceShort($article['Article']['modified'])?></td>
	<td><?=$article['Category']['title']?></td>
	<td><a href="/admin/articlesEdit/<?=$id?>"><?=$article['Article']['title']?></a></td>
	
</tr>
<?
	}
?>

</tbody>
</table>
<?=$this->element('pagination', array('plugin' => 'paginate'))?>
</form>
<script type="text/javascript">
$(document).ready(function() {
	if ($.cookie('articleFilter')) {
		$('.articleFilter').removeClass('hide');
	}
<?
	if ($selected) {
?>
	$('#Article__object_id').val(<?=$selected?>);
<?
	}
?>
});
function article_onFilter() {
	if ($('.articleFilter').hasClass('hide')) {
		// show
		$('.articleFilter').removeClass('hide');
		$.cookie('articleFilter', 1, {expire: 365, path: '/'});
	} else { // hide
		$('.articleFilter').addClass('hide');
		$.cookie('articleFilter', 0, {expire: 365, path: '/'});
	}
}

function article_onSubmitFilter() {
	var url = window.location.href;
	var xurl = '';
	$('.articleFilter :input').each(function() {
		
			var id = this.id.replace(/__/, '.');
			if (url.indexOf(id) == -1) { // not found
				if ($(this).val()) {
					xurl+= '/' + id + ':' + $(this).val();
				}
			} else {
				re = new RegExp('\/' + this.id.replace(/__/, '\\.') + ':[\\w%\\*]*');	
				if ($(this).val()) {
					url = url.replace(re, '\/' + id + ':' + $(this).val());
				} else {
					url = url.replace(re, '');
				}
			}
		
	});
	url+= xurl;
	window.location.href = url;
	return false;
}

function article_onClearFilter() {
	$('.articleFilter :input').val('');
	article_onSubmitFilter();
}
</script>