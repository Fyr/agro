<?
	$this->PHCore->css(array('grid/grid', 'jquery.fancybox'));
	$this->PHCore->js(array('jquery.fancybox.js')); //
?>
					<div class="area">
						<?=$this->element('title', array('title' => $aArticle['Article']['title']))?>
						<div class="text">

<?
	if (isset($aArticle['Media'])) {
		$aMedia = $aArticle['Media'];
		foreach($aMedia as $media) {
			if ($media['ext'] == '.pdf') {
?>
	<div style="float: right">
		<a href="<?=$this->PHMedia->getRawUrl('article', $media['id'], $media['file'].$media['ext'])?>">Скачать <b><?=$media['file'].$media['ext']?></b></a>
	</div>
<?
				break;
			}
		}
	}
?>
							<b><?__('Brand')?></b> : <?=$aArticle['Brand']['title']?><br />
							<b><?__('Type')?></b> : <?=$aArticle['Category']['title']?><br />

<?
	if ($aArticle['Article']['price']) {
?>
							<b><?__('Price')?></b> : <?=PU_.$aArticle['Article']['price']._PU?>
<?
	}
?>
							<div style="margin-top: 20px">
								<?=$this->element('article_view', array('plugin' => 'articles'))?>
							</div>
							<!-- div class="line" style="width: 100%"></div-->
						</div>
					</div>
					<div class="section">
						<div class="s-frame gallery">
<?
	foreach($aArticle['Media'] as $media) {
		$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], '130x100', $media['file'].$media['ext'].'.png');
		$orig = $this->PHMedia->getUrl($media['object_type'], $media['id'], 'noresize', $media['file'].$media['ext'].'.png');
?>
							<div class="block three3">
								<br/>
								<div class="image" style="text-align:center">
									<a href="<?=$orig?>" rel="photoalobum"><img alt="<?=$aArticle['Article']['title']?>" src="<?=$src?>" /></a>
								</div>
							</div>
<?
	}
?>
						</div>
					</div>

					<div class="area">
						<div class="text">
<?
	if ($aParamValues) {
?>
	<h3><?__('Tech.parameters')?></h3>
	<table class="grid" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th><?__('Parameter')?></th>
		<th><?__('Value')?></th>
	</tr>
	</thead>
	<tbody>
<?
	$class = '';
	foreach($aParamValues as $param) {
		$class = ($class == 'odd') ? 'even' : 'odd';
?>
	<tr class="gridRow <?=$class?> td">
		<td nowrap="nowrap"><?=$param['Param']['title']?></td>
		<td><b><?=$this->element('param_render', array('plugin' => 'params', 'param' => $param))?></b></td>
	</tr>
<?
	}
?>
	</tbody>
	</table>
<?
	}
?>
	<br />
	<a href="/products/">Перейти в каталог</a>
<?
/*
	if ($aSimilar) {
?>
	<div class="line" style="width: 100%"></div>
	<h3><?__('Similar products')?></h3>
<?
		foreach($aSimilar as $article) {
			$this->ArticleVars->init($article, $url, $title, $teaser, $src, '150x', $featured);
?>
	<a href="<?=$url?>"><?=$title?></a><br />
<?
		}
	}
	*/
?>
						</div>
					</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.gallery .image a').fancybox({
		padding: 5
	});

});
</script>