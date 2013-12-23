<div class="tagsEdit">
	<?=$this->element('tags_edit', array('plugin' => 'tags', 'aTags' => $aTags, 'aRelatedTags' => $aRelatedTags, 'object_type' => $object_type, 'object_id' => $object_id))?>
</div>
<div class="process_sample hide">
	<?=$this->element('processing', array('plugin' => 'core'))?>
</div>