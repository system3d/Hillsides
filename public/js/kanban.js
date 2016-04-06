$(document).ready(function() {

   $("#modal").on('hide.bs.modal', function () {
       modal_history = [false];
    });

  $('#backlogToggle').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
  });

  $('#arquivToggle').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
  });

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

   /////////

   $(document).on('click', '#loadProjInfoKanban', function(event) {
     event.preventDefault();
      $('#loader').removeClass('hidden'); 
     var id = $(this).attr('data-id');
         $.ajax({
            url: urlbaseGeral+"/projetos/info",
            type: 'POST',
            dataType: 'html',
            data:{id:id,kanban:'nao'},
          })
          .done(function(response) {
            drawModal(response, '50%');
          });
        $('#loader').addClass('hidden'); 
   });

   $(document).on('click', '#loadProjHistKanban', function(event) {
     event.preventDefault();
     var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/kanban/historia",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'50%');
      });
   });

   $(document).on('click', '#novaTarefaKanban', function(event) {
     event.preventDefault();
     $('#loader').removeClass('hidden'); 
     var id = $(this).attr('data-id');
     var sprint = $('#selectSprints').val();
     var story = $('#selectStory').val();
     var user = $('#selectUser').val();
     var disc = $('#selectDisc').val();
     var etapa = $('#selectEtapa').val();
     $.ajax({
        url: urlbaseGeral+"/tarefa/criar",
        type: 'POST',
        dataType: 'html',
        data:{id:id,sprint:sprint,story:story,user:user,dis:disc,etapa:etapa},
      })
      .done(function(response) {
        drawModal(response, '60%');
      });
    $('#loader').addClass('hidden'); 
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
  
