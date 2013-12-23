function showCategories(id) {
	if ($('#cat-nav' + id + ' a').hasClass('active')) {
		$('#cat-nav' + id + ' a').removeClass('active');
		$('#cat-nav' + id + ' .subnav').slideUp();
	} else {
		$('#cat-nav' + id + ' a').addClass('active');
		$('#cat-nav' + id + ' .subnav').slideDown();
	}
}