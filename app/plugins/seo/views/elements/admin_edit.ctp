<table class="seo pad5" border="0" cellpadding="0" cellspacing="0">
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Title', true), 'field' => 'Seo.title', 'data' => $data, 'size' => '70'))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Description', true), 'field' => 'Seo.descr', 'data' => $data, 'size' => '70'))?>
<?=$this->element('std_input', array('plugin' => 'core', 'caption' => __('Keywords', true), 'field' => 'Seo.keywords', 'data' => $data, 'size' => '70'))?>
</table>
<input type="hidden" name="data[Seo][object_type]" value="<?=$object_type?>" />
<?
	if ($id = $this->PHA->read($data, 'Seo.id')) {
?>
<input type="hidden" name="data[Seo][id]" value="<?=$id?>" />
<?
	}
?>