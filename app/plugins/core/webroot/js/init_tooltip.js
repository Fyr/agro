$(document).ready(function(){
	$(".tooltip").tooltip({
		bodyHandler: function() {
			return $('.tooltipContent', this).html();
		},
		showURL: false
	});
});