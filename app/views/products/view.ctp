<?
	$this->PHCore->css(array('grid/grid', 'jquery.fancybox'));
	$this->PHCore->js(array('jquery.fancybox.pack.js')); //
	$title = $aArticle['Article']['code'].' '.$aArticle['Article']['title_rus'];
	$alt = $aArticle['Article']['title_rus'].' '.$aArticle['Article']['detail_num'];
	
	$price_by = Configure::read('params.price_by');
	$price_ru = Configure::read('params.price_ru');
	$price2_ru = Configure::read('params.price2_ru');
?>
						<?=$this->element('title', array('title' => $title))?>
						<div class="block main clearfix">

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
	if ($aArticle['Article']['active']) {
?>
											<img class="floatR" src="/img/active_yes.png" alt="В наличии" />
<?
	} else {
?>
											<img class="floatR" src="/img/active_no.png" alt="Не на складе" />
<?
	}
?>
							<b><?__('Brand')?></b> : <?=$aArticle['Brand']['title']?><br />
							<!--b><?__('Type')?></b> : <?=$aArticle['Category']['title']?><br /-->
<?
	$price = 0;
	if ($_SERVER['SERVER_NAME'] == 'agromotors.ru') {
		if (isset($aParamValues[$price_ru]) && $aParamValues[$price_ru]) {
			$price = $aParamValues[$price_ru]['ParamValue']['value'];
		} elseif (isset($aParamValues[$price2_ru]) && $aParamValues[$price2_ru]) {
			$price = $aParamValues[$price2_ru]['ParamValue']['value'];
		}
	} else {
		if (isset($aParamValues[$price_by]) && $aParamValues[$price_by]) {
			$price = $aParamValues[$price_by]['ParamValue']['value'];
		}
	}

	if ($price) {
?>
							<b><?__('Price')?></b> : <?=PU_.$price._PU?><br />
<?
	}
?>
							<div style="margin-top: 20px">
								<?=$this->element('article_view', array('plugin' => 'articles'))?>
							</div>
							<!-- div class="line" style="width: 100%"></div-->
						</div>
						<div class="gallery">
<?
	if (isset($aArticle['Media']) && $aArticle['Media']) {
		foreach($aArticle['Media'] as $media) {
			$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], '130x100', $media['file'].$media['ext'].'.png');
			$orig = $this->PHMedia->getUrl($media['object_type'], $media['id'], 'noresize', $media['file'].$media['ext'].'.png');
?>
								<div class="image" style="text-align:center">
									<a href="<?=$orig?>" rel="photoalobum"><img alt="<?=$alt?>" src="<?=$src?>" /></a>
								</div>
<?
		}
	} else {
		$src = '/img/default_product.jpg';
		if ($brand && isset($brand['Media']) && isset($brand['Media'][0]) && $brand['Media'][0]['id']) {
			$media = $brand['Media'][0];
			$src = $this->PHMedia->getUrl($media['object_type'], $media['id'], '130x100', $media['file'].$media['ext']);
		}
?>
								<div class="image" style="text-align:center">
									<img alt="<?=$alt?>" src="<?=$src?>" style="width: 130px" />
								</div>

<?
	}
?>
						</div>

<?
	if ($aArticle['Article']['show_detailnum']) {
		$aParamValues[''] = array(
			'ParamValue' => array('param_id' => '', 'value' => $aArticle['Article']['detail_num']),
			'Param' => array('title' => 'Номер детали', 'param_type' => 4)
		);
		ksort($aParamValues);
	}
	if ($aParamValues) {
?>
	<h3><?__('Tech.parameters')?></h3>
	<table class="grid" width="100%" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th width="30%"><?__('Parameter')?></th>
		<th><?__('Value')?></th>
	</tr>
	</thead>
	<tbody>
<?
	$class = '';
	foreach($aParamValues as $param_id => $param) {
		
		if (in_array($param_id, array($price_by, $price_ru, $price2_ru))) {
			continue;
		}
		
		$class = ($class == 'odd') ? 'even' : 'odd';
		if ($param_id == Configure::read('params.motor')) { // Мотор показываем как строку
			$param['Param']['param_type'] = Param::STRING;
			$param['ParamValue']['value'] = str_replace(',', ', ', $param['ParamValue']['value']);
		}
		if (trim($param['ParamValue']['value'])) {
?>
	<tr class="gridRow <?=$class?> td">
		<td nowrap="nowrap" align="right"><?=$param['Param']['title']?></td>
		<td><b><?=$this->element('param_render', array('plugin' => 'params', 'param' => $param))?></b></td>
	</tr>
<?
		}
	}
?>
	</tbody>
	</table>
<?
	}
?>
	<br />
	<a href="/zapchasti/">Перейти в каталог</a>
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

<script type="text/javascript">
$(document).ready(function(){
	$('.gallery .image a').fancybox({
		padding: 5
	});

});
</script>