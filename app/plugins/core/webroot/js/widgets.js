function expandableBlockWidgetToggle(id) {
	$('#' + id + ' .switch').toggleClass('down');
	$('#' + id + ' .container').toggleClass('collapse');
}