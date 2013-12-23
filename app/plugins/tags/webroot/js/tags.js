function tag_onAdd(object_type, object_id) {
	tag = $('#Tag__title').val();
	if (tag) {
		$('.tagsEdit').html($('.process_sample').html());
		$('.tagsEdit .processing').show();
		$('.tagsEdit').load('/tags/ajax/add/', {data: {object_type: object_type, object_id: object_id, tag: tag}});
	}
}

function tag_onBind(tagID, object_type, object_id) {
	$('#tag_' + tagID + ' span').hide();
	$('#tag_' + tagID).append($('.process_sample').html());
	$('#tag_' + tagID + ' .processing').show();
	$.post('/tags/ajax/bind/', 
		{data: {object_type: object_type, object_id: object_id, tag_id: tagID, set: ($('#tag_' + tagID + ' input').get(0).checked) ? 1 : 0}}, 
		function(){ tag_onBindComplete(tagID); }
	);
}

function tag_onBindComplete(tagID) {
	$('#tag_' + tagID + ' span').show();
	$('#tag_' + tagID + ' .processing').remove();
}

function tag_onDel(tagID, object_type, object_id) {
	$('#tag_' + tagID + ' span').hide();
	$('#tag_' + tagID).append($('.process_sample').html());
	$('#tag_' + tagID + ' .processing').show();
	$('.tagsEdit').load('/tags/ajax/del/', 
		{data: {object_type: object_type, object_id: object_id, tagID: tagID}}
	);
}