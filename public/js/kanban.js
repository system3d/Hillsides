$(document).ready(function() {
    handleCookies();
    getTarefas();

    $('#load_tasks').click(function(event) {
      event.preventDefault();
      getTarefas();
    });

    $('#navForm').submit(function(event) {
      event.preventDefault();
    });

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
        if(did === 0){
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


	 $(".sortable-row").sortable({
  	 	connectWith: ".sortable-row",
  	 	cancel: ".NotSortable",
      tolerance: 'pointer',
      placeholder: 'dragHelper',
      revert: true,
      forceHelperSize: true,
      receive: function( event, ui ) {
        var target = $(event.target);
        var task = ui.item;
        var estagio = target.attr('data-estagio');
        var id = task.attr('data-id');
        $.ajax({
            url: urlbaseGeral+"/tarefa/moved",
            type: 'POST',
            dataType: 'html',
            data:{id:id,estagio:estagio},
          })
          .done(function(r) {
            if(r == '405'){
              flashMessage('warning', 'Você não tem permissão para fazer isto.');
              $(ui.sender).sortable('cancel');
            }
          });
      },
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



   //Cadastro de Tarefas //

    $(document).on('submit', '#tarefa_cadastro', function(event) {
      event.preventDefault();

       var formData = new FormData($(this)[0]);
       $.ajax({
           type:'POST',
            url: urlbaseGeral+"/tarefa/store",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
           dataType: 'json',
        }).done(function(r) {
        flashMessage(r.status, r.msg);
        if(r.status == 'success'){
           $.ajax({
          url: urlbaseGeral+"/tarefa",
          type: 'POST',
          dataType: 'html',
          data:{id:r.id},
        })
        .done(function(response) {
          drawModal(response, '40%');
           $('#kanban_loader').addClass('hidden');
        });
         singleTask(r.id);

        }
      });
    });

   //////////////////////

   $('#backlogToggle').on('ifChanged', function(event){
    $('.backlog').toggleClass('hidden');
    if($.cookie('backlog')){
      if ($('#backlogToggle').is(":checked")) {
        var cook = 'true';
      }else{
        var cook = 'false';
      }
     $.cookie('backlog', cook, { expires: 90 });
    }else{
      $.cookie('backlog', 'false', { expires: 90 });
    }
  });

   $('#arquivToggle').on('ifChanged', function(event){
    $('.arquivo').toggleClass('hidden');
     if($.cookie('arqui')){
      if ($('#arquivToggle').is(":checked")) {
        var cook = 'true';
      }else{
        var cook = 'false';
      }
      var cook = $.cookie('arqui');
      cook = (cook == 'false' ? 'true' : 'false');
     $.cookie('arqui', cook, { expires: 90 });
    }else{
      $.cookie('arqui', 'false', { expires: 90 });
    }
  });

   //////////////


   $(document).on('click', '.tarefa-info', function(event) {
     event.preventDefault();
     var id = $(this).attr('data-id');
      $.ajax({
          url: urlbaseGeral+"/tarefa",
          type: 'POST',
          dataType: 'html',
          data:{id:id},
        })
        .done(function(response) {
          drawModal(response, '40%');
        });
   });



});

function isDark( color ) {
    var match = /rgb\((\d+).*?(\d+).*?(\d+)\)/.exec(color);
    return parseFloat(match[1]) + parseFloat(match[2]) + parseFloat(match[3]) < 3 * 256 / 2; // r+g+b should be less than half of max (3 * 256)
}

function verticalTextAlign(){
  $('.text-vertical').each(function(index, el) {
  $(this).html($(this).text().replace(/(.)/g,"$1<br />"));
  });
}

function handleCookies(){
  if($.cookie('backlog')){
    var backlog = $.cookie('backlog');
  }else{
    var backlog = 'true';
  }
   if($.cookie('arqui')){
    var arqui = $.cookie('arqui');
  }else{
    var arqui = 'true';
  }
  if(backlog == 'false'){
    $('#backlogToggle').iCheck('uncheck');
    $('.backlog').toggleClass('hidden');
  }
  if(arqui == 'false'){
    $('#arquivToggle').iCheck('uncheck');
    $('.arquivo').toggleClass('hidden');
  }
}

function singleTask(id){
  $('#kanban_loader').removeClass('hidden');
       $.ajax({
          url: urlbaseGeral+"/getTarefa",
          type: 'POST',
          dataType: 'json',
          data:{id:id},
        }).done(function(r) {
          var th = taskHtml(r);
          injectTask(th,r.historia_id,r.estagio_id);
          setColorSingle(r.id);
         $('#kanban_loader').addClass('hidden');
        });
}

//get all the projext tasks by requesting them to server, it sends back a json with the task properties, then we format the html and append it to the board with the 
//functions below(taskHtml/injectTask)
function getTarefas(){
  $('#kanban_loader').removeClass('hidden');
      
      var projeto = $('#projeto_id_kanban').val();
      var sprint = $('#selectSprints').val();
       var story = $('#selectStory').val();
       var user = $('#selectUser').val();
       var disc = $('#selectDisc').val();
       var etapa = $('#selectEtapa').val();
      var equipe = $('#selectEquipe').val();
       $.ajax({
          url: urlbaseGeral+"/getTarefas",
          type: 'POST',
          dataType: 'json',
          data:{projeto:projeto,sprint:sprint,story:story,user:user,dis:disc,etapa:etapa,equipe:equipe},
        }).done(function(r) {
          if(r.count > 0){
            var tasks = r.tasks;
            $('.tarefa').remove();
            for(var k in tasks) {
                var th = taskHtml(tasks[k]);
                injectTask(th,tasks[k].historia_id,tasks[k].estagio_id);
            }
            setColor();
          }
         $('#kanban_loader').addClass('hidden');
        });
}

//receive the json of the task provenient of the getTarefa/getTarefas routes
function taskHtml(task){
var response = '<div class="tarefa" data-story="'+task.historia_id+'" style="background-color:'+task.cor+'" data-id="'+task.id+'">';
response +=     '<span class="red-pin"></span>';
response +=       '<div class="tarefa-body">';
response +=         '<p class="tarefa-title tarefa-info" data-id="'+task.id+'"><span data-toggle="tooltip" data-html="true" title="'+task.tarefa+'">'+task.tarefa+'</span></p>';
response +=           '<ul class="tarefa-list">';
response +=             '<li>'+task.status+'</li>';
response +=             '<li>'+task.disciplina+'</li>';
response +=             '<li>'+task.etapa+'</li>';
response +=           '</ul>';
response +=         '</div>';
response +=        '<div class="tarefa-footer">';
response +=          '<img class="img-circle tarefa-img tarefa-img-user" src="'+task.user_icone+'"  data-toggle="tooltip" data-html="true" title="'+task.assignee+'">';
response +=          '<img class="img-circle tarefa-img tarefa-img-tipo tarefa-info" data-id="'+task.id+'" src="'+task.tipo_icone+'"  data-toggle="tooltip" data-html="true" title="'+task.tipo+'">';
response +=       '</div>';
response +=     '</div>';

return response;
}

/**
/*Receives the html of the task, obtained by the taskHtml function, historia_i and estagio_id of the task
**/
function injectTask(task,hist,est){
  $('.sortable-row[data-story="'+hist+'"][data-estagio="'+est+'"]').append(task);
}
  
function setColor(){
  $('.tarefa').each(function(index, el) {
    var t_color = $(el).css('background-color');
    $(el).find('.tarefa-body').css('color', isDark(t_color) ? 'white' : 'black');
  });
}


function setColorSingle(id){
  var tarefa = $('.tarefa[data-id="'+id+'"]');
  var t_color = tarefa.css('background-color');
  $(tarefa).find('.tarefa-body').css('color', isDark(t_color) ? 'white' : 'black');
}

//function to move tasks, receives just the task 'data-id' and the estagio('data-estagio of the td')
function moveTask(id,est){
var task = $('.tarefa[data-id="'+id+'"]');
var hist = task.attr('data-story');
//First we copy the arrow to the new table cell and get the offset to the document
var newo = task.clone().appendTo('.sortable-row[data-story="'+hist+'"][data-estagio="'+est+'"]');
var newOffset = newo.offset();
//Get the old position relative to document
var oldOffset = task.offset();
//we also clone old to the document for the animation
var temp = task.clone().appendTo('body');
//hide new and old and move $temp to position
//also big z-index, make sure to edit this to something that works with the page
temp.css('position', 'absolute').css('left', oldOffset.left).css('top', oldOffset.top).css('zIndex', 1000);
newo.hide();
task.hide();
//animate the $temp to the position of the new img
temp.animate( {'top': newOffset.top, 'left':newOffset.left}, 'slow', function(){
   //callback function, we remove $old and $temp and show $new
   newo.show();
   task.remove();
   temp.remove();
});
}

function reloadKBPage(){
   var projeto = $('#projeto_id_kanban').val();
   var sprint = $('#selectSprints').val();
   var story = $('#selectStory').val();
   var user = $('#selectUser').val();
   var disc = $('#selectDisc').val();
   var etapa = $('#selectEtapa').val();
   var equipe = $('#selectEquipe').val();
    $.ajax({
        url: urlbaseGeral+"/kanban/setHistory",
        type: 'POST',
        dataType: 'html',
        data:{projeto:projeto,sprint:sprint,story:story,user:user,dis:disc,etapa:etapa,equipe:equipe},
      }).done(function(r) {
         window.location.href = r;
      });
}

