$(document).ready(function($) {
	var windHeight = $(window).height();
	var boxHeight = windHeight - 150;
	if(boxHeight < 440){
		boxHeight = 440;
	}
	$('#messages-box-wrapper').css('height', boxHeight);
})