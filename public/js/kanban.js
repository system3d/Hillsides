$(document).ready(function() {

  $(document).on('click', '.column-collapse', function(event) {
    event.preventDefault();
    var head = $(this).parent('th');
    var phase = head.attr('data-phase');

    if(head.hasClass('column-collapsed')){
      var thisWidth = 'auto';
     $("td[data-phase]").each(function(){
        var thisPhase = $(this).attr('data-phase');
       if(thisPhase == phase){
        $(this).find('.text-vertical').remove();
        thisWidth = $(this).attr('data-width');
        $(this).removeClass('NotSortable');
        $(this).addClass('sortable-row');
        $(this).css('width', thisWidth);
        $(this).find('.tarefa').removeClass('hidden');
       }
    });
     head.css('width', thisWidth);
      head.removeClass('column-collapsed');
      head.html(phase+'<span class="column-collapse column-hover hidden"><i class="fa fa-minus"></i></span>');
    }else{
      var did = 0;
     $("td[data-phase]").each(function(){
      
       var thisPhase = $(this).attr('data-phase');
       if(thisPhase == phase){
        if(did == 0){
          var bodyHeight = $('#kanbanBody').height();
          if(bodyHeight < 145)
            phasePrint = phase.toUpperCase().substring(0,7);
          else
            phasePrint = phase.toUpperCase().substring(0,18);
          $(this).append('<strong class="text-vertical">'+phasePrint+'</strong>');
          verticalTextAlign();
          did++;
        }
        $(this).addClass('NotSortable');
        $(this).removeClass('sortable-row');
        $(this).css('width', '19px');
        $(this).find('.tarefa').addClass('hidden');
       }
    });
      head.addClass('column-collapsed');
      head.css('width', '19px');
      head.html('<span class="column-collapse"><i class="fa fa-plus"></i></span>');
    }
  });

  $(document).on('mouseenter', 'th', function(event) {
    $(this).find('.column-hover').removeClass('hidden');
  });

  $(document).on('mouseleave', 'th', function(event) {
    $(this).find('.column-hover').addClass('hidden');
  });

  verticalTextAlign();

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

function isDark( color ) {
    var match = /rgb\((\d+).*?(\d+).*?(\d+)\)/.exec(color);
    return parseFloat(match[1])
         + parseFloat(match[2])
         + parseFloat(match[3])
           < 3 * 256 / 2; // r+g+b should be less than half of max (3 * 256)
}

function verticalTextAlign(){
  $('.text-vertical').each(function(index, el) {
  $(this).html($(this).text().replace(/(.)/g,"$1<br />"));
  });
}
  
