<?
	$this->Html->css('/category/css/category', null, array('inline' => false));
	$this->Html->script(array('/core/js/jquery.form'), array('inline' => false));
	
	$aParams = array('plugin' => 'category', 'aCategoryOptions' => $aCategoryOptions);
	if (isset($selected)) {
		$aParams['selected'] = $selected;
	}
?>

<form id="catForm" name="catForm" action="/category/ajax/submit" method="post">
<span class="catManage hide" style="background: #fff; position: relative; top: 7px; left: 10px;">&nbsp;<? __('Manage categories');?>&nbsp;</span>
<div class="catBorder" style="width: 570px; padding: 10px">
<table class="pad5" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<?=$this->element('icon_action', array('plugin' => 'core', 'img' => 'settings.png', 'class' => 'fixIcon', 'title' => __('Click to show\hide controls for categories', true), 'onclick' => 'category_onManage()'))?>
		<? __('Category');?>
	</td>
	<td>
		<select id="catList" name="catSelect" onchange="category_onChange()">
		<?=$this->element('category_options', $aParams)?>
		</select>
		<span class="catManage hide">
			<?=$this->element('icon_edit', array('plugin' => 'core', 'onclick' => "category_onEdit()"))?>
			<?=$this->element('icon_del', array('plugin' => 'core', 'onclick' => 'category_onDel()'))?>
			<?=$this->element('processing', array('plugin' => 'core'))?>
		</span>
	</td>
</tr>
<tr class="catManage hide">
	<td>&nbsp;</td>
	<td>
		<input type="hidden" id="catEdit" name="data[Category][id]" value="" />
		<input type="hidden" id="catObjectType" name="data[Category][object_type]" value="" />
		<input type="text" id="catTitle" name="data[Category][title]" value="" />
		<!-- input type="hidden" id="catATop" name="catATop" value="" /-->
		<?=$this->element('icon_add', array('plugin' => 'core', 'onclick' => "category_onAdd()"))?>
		<?=$this->element('icon_save', array('plugin' => 'core', 'class' => 'hide', 'onclick' => "$('#catForm').submit()"))?>
		<br />
		<input class="checkbox" type="checkbox" id="catTop" name="data[Category][featured]" value="1" /> <? __('Featured category');?>
	</td>
</tr>
</table>
</div>
</form>

<script type="text/javascript">
$(document).ready(function() {
	var options = {
		target: '#catList',
		beforeSubmit: category_beforeSubmit,
		success: category_afterSubmit
	};
	$('#catForm').ajaxForm(options);
	$('#catObjectType').val($('#catObj').val());
<?
	if ($selected) {
?>
	$('#catList').val(<?=$selected?>);
<?
	}
?>
	category_onChange();
});

function category_onManage() {
	if ($('.catManage').hasClass('hide')) {
		// show 
		$('.catManage').removeClass('hide');
		$('.catBorder').addClass('border');
	} else {
		$('.catManage').addClass('hide');
		$('.catBorder').removeClass('border');
	}
}

function category_beforeSubmit() {
	$('#catForm .icon').hide();
	$('#catForm .processing').show();
}

function category_afterSubmit() {
	$('#catForm .icon_add').show();
	$('#catForm .processing').hide();
}

function category_updateIcons() {
	$('#catForm .icon_add').show();
	if ($('#catList').val()) {
		$('#catForm .icon_edit').show();
		$('#catForm .icon_del').show();
		// $('.icon_add').hide();
		$('#catForm .icon_save').hide();
	} else {
		$('#catForm .icon_edit').hide();
		$('#catForm .icon_del').hide();
		// $('.icon_add').show();
		$('#catForm .icon_save').hide();
	}
}

function category_onAdd() {
	$('#catEdit').val('');
	$('#catForm').submit();
}

function category_onChange() {
	$('#catID').val($('#catList').val());
	category_updateIcons();
}

function category_onEdit() {
	catList = $('#catList').get(0);
	$('#catEdit').val($('#catList').val());
	$('#catTitle').val(catList.options[catList.selectedIndex].text);
	$('#catForm .icon_add').hide();
	$('#catForm .icon_save').show();
}

function category_onDel() {
	$('#catForm .icon').hide();
	$('#catForm .processing').show();
	$.get('/category/ajax/del/' + $('#catList').val(), null, function(data){ category_afterDel(data); });
}

function category_afterDel(data) {
	$('#catForm .processing').hide();
	if (data.substr(0, 6) == 'Error:') {
		$('.errMsg').html(data.substr(6));
	} else {
		$('#catList').html(data);
	}
	category_updateIcons();
}

</script>
