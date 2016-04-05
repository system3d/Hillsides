$(document).ready(function() {
	$('.tarefa').each(function(index, el) {
		var t_color = $(el).css('background-color');
		$(el).find('.tarefa-body').css('color', isDark(t_color) ? 'white' : 'black');
	});

	 $(".sortable-row").sortable({
	 	connectWith: ".sortable-row",
	 	cancel: ".NotSortable",
        tolerance: 'pointer',
        placeholder: 'dragHelper',
		revert: true,
        forceHelperSize: true,
    });

	 $('.sortable-row').each(function(){
	    var ThisId = $(this).attr('data-story');
		$(this).sortable( "option", "containment", "#H-"+ThisId );
	});
});





function inverRgb(rgb) {
  rgb = Array.prototype.join.call(arguments).match(/(-?[0-9\.]+)/g);
  for (var i = 0; i < rgb.length; i++) {
    rgb[i] = (i === 3 ? 1 : 255) - rgb[i];
  }
  var response = 'rgb(';
  var xc = 0;
  rgb.forEach(function(c) {
  	
    response = response + c;
    if(xc != 2)
    response = response + ',';
	else
	response = response + ')';
  xc++;
});
  return response;
}

function isDark( color ) {
    var match = /rgb\((\d+).*?(\d+).*?(\d+)\)/.exec(color);
    return parseFloat(match[1])
         + parseFloat(match[2])
         + parseFloat(match[3])
           < 3 * 256 / 2; // r+g+b should be less than half of max (3 * 256)
}
