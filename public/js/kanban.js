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
      containment: "tbody",
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
      var nova = 0;
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
         singleTask(r.id);
         $('html,body').animate({ 
            scrollTop: $('#H-'+r.story).offset().top
        }, 500);
        startGoTop();
         $('#modal').modal('hide');
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
          $(".form-static").linkify({
              target: "_blank"
          });
        });
   });

    $(document).on('click', '.edit-tarefa', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
            url: urlbaseGeral+"/tarefa/editar",
            type: 'POST',
            dataType: 'html',
            data:{id:id},
          })
          .done(function(response) {
            drawModal(response, '60%');
          });
  });

    $(document).on('submit', '#tarefa_update', function(event) {
    event.preventDefault();
    $('#modal_loader').removeClass('hidden');
    var values = $(this).serializeAndEncode();
    
    $.ajax({
      url: urlbaseGeral+"/tarefa/update",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    }).done(function(r){

      flashMessage(r.status, r.msg);

      if(r.status == 'success'){
        var sid = r.id;
        $('.tarefa[data-id="'+sid+'"]').remove();
        var th = taskHtml(r.task);
        injectTask(th,r.task.historia_id,r.task.estagio_id);
        setColorSingle(sid);
        $.ajax({
        url: urlbaseGeral+"/tarefa",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'50%');
        
      });
    }
    $('#modal_loader').addClass('hidden');
    })
  });

$(document).on('click', '.tarefa-delete', function(event) {
  event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/tarefa/excluir",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      }).done(function(r){
       flashMessage(r.status, r.msg);
        if(r.status == 'success'){
          $('.tarefa[data-id="'+r.id+'"]').remove();
        }
        $('#modal').modal("hide");
     });
});



////////////////////


  $(document).on('change', '#selectStory', function(event) {
    var hist = $(this).val();
    if(hist == 0){
      $('.kanban-trow').removeClass('hidden');
    }else{
      $('.kanban-trow').addClass('hidden');
      $('.kanban-trow[data-story="'+hist+'"]').removeClass('hidden');
    }
  });

  $(document).on('change', '#selectSprints', function(event) {
    var sprint = $(this).val();
    if(sprint == 0){
      $('.kanban-trow').removeClass('hidden');
    }else{
      $('.kanban-trow').addClass('hidden');
      $('.kanban-trow[data-sprint="'+sprint+'"]').removeClass('hidden');
    }
  });

  //////////////////


  $(document).on('keyup', '#kanban-search', function(event) {
    event.preventDefault();
    var search = $(this).val();
    search = search.replace(/ /g,'%%').toLowerCase();
    if(search != ''){
      $('.tarefa').each(function(index, el) {
        var attrs = $(el).attr('data-search');
         if (attrs.includes(search)){
          $(el).removeClass('hidden');
         }else{
          $(el).addClass('hidden');
         }
      });
    }else{
      $('.tarefa').each(function(index, el) {
        $(el).removeClass('hidden');
      });
    }
    event.stopPropagation();
  });

  /////////////

  $(document).on('click', '.tarefa-img-user', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var task = $(this).attr('data-tarefa');
    if(id == 0){
      return false;
    }else{
      $.ajax({
        url: urlbaseGeral+"/tarefa/user",
        type: 'POST',
        data: {id:id,task:task},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'50%');
      });
    }
  });

  $("#go-to-top").click(function(e) {
    e.preventDefault();
  $("html, body").animate({ scrollTop: 0 }, "slow");
  $(this).addClass('hidden');
  return false;
});

  $(document).on('change', 'input[type="file"]', function(event) {
    $(this).next().removeClass('hidden');
  });

   $(document).on('click', '.tarefa-anexos', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
      $.ajax({
        url: urlbaseGeral+"/tarefa/anexos",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'50%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
      });
  });

   $(document).on('click', '.excluir-anexo', function(event) {
     event.preventDefault();
     var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/tarefa/excluirAnexo",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      }).done(function(r){
       flashMessage(r.status, r.msg);
        if(r.status == 'success'){
        $('.tarefa[data-id="'+r.id+'"]').remove();
        var th = taskHtml(r.task);
        injectTask(th,r.task.historia_id,r.task.estagio_id);
        setColorSingle(r.id);
        $.ajax({
        url: urlbaseGeral+"/tarefa/anexos",
        type: 'POST',
        data: {id:r.id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'50%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
      });
    }
     });
   });

   $(document).on('click', '.anexo-upload', function(event) {
     event.preventDefault();
     var id = $(this).attr('data-id');
      $.ajax({
          url: urlbaseGeral+"/tarefa/upload",
          type: 'POST',
          dataType: 'html',
          data:{id:id},
        })
        .done(function(response) {
          drawModal(response, '40%');
        });
   });

   $(document).on('submit', '#upload_anexo', function(event) {
      event.preventDefault();
      var formData = new FormData(this);
       $.ajax({
            type:'POST',
            url: urlbaseGeral+"/tarefa/storeAnexo",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
        }).done(function(r) {
        flashMessage(r.status, r.msg);
        if(r.status == 'success'){
          $('.tarefa[data-id="'+r.id+'"]').remove();
        var th = taskHtml(r.task);
        injectTask(th,r.task.historia_id,r.task.estagio_id);
        setColorSingle(r.id);
        $.ajax({
        url: urlbaseGeral+"/tarefa/anexos",
        type: 'POST',
        data: {id:r.id},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
         window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'50%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
      });
        }
      });
    });

 var thHeight = $("#kanbanBody th:first").height();
  $(".resizableColumn").resizable({
      minWidth: 150,
      maxWidth: 550,
      maxHeight: 23,
      minHeight: 23,
      handles: "e"
  });

});

function startGoTop(){
   $('#go-to-top').removeClass('hidden');
   setTimeout(function(){
      $('#go-to-top').addClass("hidden");
    }, 5000);
}

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
          $('.tarefa').remove();
          if(r.count > 0){
            var tasks = r.tasks;
            
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
var str  = task.historia+'%'+task.sprint+'%'+task.tarefa+'%'+task.status+'%'+task.estagio+'%'+task.tipo+'%'+task.peso+'%'+task.obs;
var search = str.toString();
search = search.replace(/ /g,'%%').toLowerCase();
var response = '<div class="tarefa" data-story="'+task.historia_id+'" style="background-color:'+task.cor+'" data-id="'+task.id+'" data-search="'+search+'">';
response +=     '<span class="red-pin"></span>';
response +=      task.anexos;
response +=       '<div class="tarefa-body">';
response +=         '<p class="tarefa-title tarefa-info" data-id="'+task.id+'" data-toggle="tooltip" data-html="true" title="'+task.tarefa+'"><span>'+task.tarefa+'</span></p>';
response +=           '<ul class="tarefa-list">';
response +=             '<li>'+task.status+'</li>';
response +=           '</ul>';
response +=         '</div>';
response +=        '<div class="tarefa-footer">';
response +=          '<img class="img-circle tarefa-img tarefa-img-user" data-tarefa="'+task.id+'" src="'+task.user_icone+'" data-id="'+task.assignee_id+'" data-toggle="tooltip" data-html="true" title="'+task.assignee+'">';
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

