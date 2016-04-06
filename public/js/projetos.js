 $(document).ready(function(){

 	var projetosTable = $('#projetosTable').DataTable({
            ajax: {
              type: 'POST',
              url: urlbaseGeral+"/projetos/getProjetos",
            },
            responsive: true,
            columns:  [
            { "data": "nome" },
            { "data": "desc"},
            { "data": "cliente" },
            { "data": "criado" },
            { "data": "status" },
        ],
        "iDisplayLength": 25,
            "language": {
              "emptyTable": "Nenhum Projeto Cadastrada."
            },
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			$(nRow).addClass('proj-row');
			return nRow;
		}
        });

 	$(document).on('click', '#criarProjeto', function(event) {
         event.preventDefault();
         $('#loader').removeClass('hidden'); 
         $.ajax({
            url: urlbaseGeral+"/projetos/criar",
            type: 'POST',
            dataType: 'html',
          })
          .done(function(response) {
            drawModal(response, '30%');
          });
        $('#loader').addClass('hidden'); 
         });

 	$(document).on('submit', '#projeto_cadastro', function(event) {
 		$('#modal_loader').removeClass('hidden');
 		var values = $(this).serializeAndEncode();
 		event.preventDefault();
 		$.ajax({
	    url: urlbaseGeral+"/projetos/store",
	    data: {dados: values},
	    type: 'POST',
	    dataType: 'json',
	  })
	  .done(function(r) {
	  	flashMessage(r.status, r.msg);
	  	$('#modal').modal("hide");
	  	$('#projetosTable').DataTable().ajax.reload();
        $('#modal_loader').addClass('hidden');
	  });
 	});


 	$(document).on('click', '.projeto-info', function(event) {
 		event.preventDefault();
 		 $('#loader').removeClass('hidden'); 
 		 var id = $(this).attr('data-id');
         $.ajax({
            url: urlbaseGeral+"/projetos/info",
            type: 'POST',
            dataType: 'html',
            data:{id:id},
          })
          .done(function(response) {
            drawModal(response, '50%');
          });
        $('#loader').addClass('hidden'); 
         });

 	$(document).on('click', '.proj-row', function(event) {
 		event.preventDefault();
 		var id = $(this).find('.projeto-info').attr('data-id');
 		$.ajax({
            url: urlbaseGeral+"/projetos/info",
            type: 'POST',
            dataType: 'html',
            data:{id:id},
          })
          .done(function(response) {
            drawModal(response, '50%');
          });
 	});

 	$(document).on('click', '.info-edit-projeto', function(event) {
 		event.preventDefault();
 		var id = $(this).attr('data-id');
 		$.ajax({
            url: urlbaseGeral+"/projetos/editar",
            type: 'POST',
            dataType: 'html',
            data:{id:id},
          })
          .done(function(response) {
            drawModal(response, '30%');
          });
 	});

 	$(document).on('click', '.projeto-favorite', function(event) {
 		event.preventDefault();
 		var id = $(this).attr('data-id');
 		var dis = $(this);
 		$.ajax({
            url: urlbaseGeral+"/projetos/toggleFavorite",
            type: 'POST',
            dataType: 'html',
            data:{id:id},
          })
          .done(function(r) {
          	if(r == 'success'){
	            $('.projeto-favorite').toggleClass('btn-default-purple');
	            $('.projeto-favorite').toggleClass('bg-purple');
	            if(dis.attr('data-original-title') == 'Adicionar a Favoritos'){
	            	dis.attr('data-original-title', 'Remover de Favoritos');
	            }else{
	            	dis.attr('data-original-title', 'Adicionar a Favoritos');
	            }
        	}
          });
 	});

  $(document).on('submit', '#projeto_atualizar', function(event) {
    event.preventDefault();
    $('#modal_loader').removeClass('hidden');
    var values = $(this).serializeAndEncode();
    
    $.ajax({
      url: urlbaseGeral+"/projetos/update",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    }).done(function(r){
      flashMessage(r.status, r.msg);
      $('#modal').modal("hide");
      $('#projetosTable').DataTable().ajax.reload();
      $('#modal_loader').addClass('hidden');
    })
  });

  $(document).on('click', '.projeto-equipes', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
      url: urlbaseGeral+"/projetos/equipes",
      type: 'POST',
      dataType: 'html',
      data:{id:id},
    })
    .done(function(response) {
      drawModal(response, '50%');
    });
  });

  $(document).on('click', '.ver-equipe', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
        url: urlbaseGeral+"/equipes/info",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response, '40%');
      });
  });

  $(document).on('click', '.close-info-small', function(event) {
    event.preventDefault();
    $('#info-equi-container').addClass('hidden');
  });

  $(document).on('click', '#save-equipe', function(event) {
         event.preventDefault();
         $(this).find('i').removeClass('fa-check');
         $(this).find('i').addClass('fa-spinner');
         $(this).find('i').addClass('fa-spin');
         var id = $('#nova-equipe').val();
         var proj_id = $('#nova-equipe').attr('data-projeto-id');
          $.ajax({
        url: urlbaseGeral+"/projetos/novaEquipe",
        data: {id: id, proj_id: proj_id},
        type: 'POST',
        dataType: 'json',
      }).done(function(rp){
        var rex = rp.msg.split('%');
        r =  rex[1];
        var res = r.split("&");
        flashMessage(res[0], res[1]);
        var eid = rp.id;
        $.ajax({
      url: urlbaseGeral+"/projetos/equipes",
      type: 'POST',
      dataType: 'html',
      data:{id:eid},
    })
    .done(function(response) {
      drawModal(response, '50%', true);
    });
      });
     });

  $(document).on('click', '.remove-equipe-proj', function(event) {
         event.preventDefault();
         var id = $(this).attr('data-id');
         var equipe_id = $(this).attr('data-projeto-id');
          $.ajax({
        url: urlbaseGeral+"/projetos/removerEquipe",
        data: {id: id, proj_id: equipe_id},
        type: 'POST',
        dataType: 'json',
      }).done(function(rp){
        var rex = rp.msg.split('%');
        r =  rex[1];
        var res = r.split("&");
        flashMessage(res[0], res[1]);
        var eid = rp.id;
        $.ajax({
            url: urlbaseGeral+"/projetos/equipes",
            type: 'POST',
            data: {id:eid},
            dataType: 'html',
          })
          .done(function(response) {
            drawModal(response, '50%', true);
          });
      });
     });

  $(document).on('click', '#ver-equipe-select', function(event) {
    event.preventDefault();
    var id = $('#nova-equipe').val();
    $.ajax({
        url: urlbaseGeral+"/equipes/infoSmall",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        $('#info-equi-container').html(response);
         $('#info-equi-container').removeClass('hidden');
      });
  });


  $(document).on('click', '#cliente-proj-info', function(event) {
    event.preventDefault();
     var id = $('#cliente-proj-info').attr('data-id');
      $.ajax({
        url: urlbaseGeral+"/cadastro/clienteinfo",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response);
      });
 	  });




  $(document).on('click', '.projeto-sprints', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
      $.ajax({
        url: urlbaseGeral+"/projetos/sprints",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
      });
  });

  $(document).on('click', '.create-sprint', function(event) {
    event.preventDefault();
     var proj_id = $(this).attr('data-proj-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/criarSprint",
        type: 'POST',
        data: {id:proj_id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'30%');
      });
  });

  $(document).on('click', '#editar-sprint', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/editarSprint",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'30%');
      });
  });

  $(document).on('submit', '#sprint_editar', function(event) {
    event.preventDefault();
    $('#modal_loader').removeClass('hidden');
    var values = $(this).serializeAndEncode();
    
    $.ajax({
      url: urlbaseGeral+"/projetos/updateSprint",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    }).done(function(r){
       if(isKanban == true){
         $('#modal_loader').removeClass('hidden'); 
         location.reload();
       }else{
      flashMessage(r.status, r.msg);
        var sid = r.id;
        $.ajax({
        url: urlbaseGeral+"/projetos/sprints",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
          $('#modal_loader').addClass('hidden');
      });
    }
    })
  });

  $(document).on('click', '#excluir-sprint', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/excluirSprint",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      })
      .done(function(r) {
        if(isKanban == true){
         $('#modal_loader').removeClass('hidden'); 
         location.reload();
       }else{
       flashMessage(r.status, r.msg);
        var sid = r.id;
        $.ajax({
        url: urlbaseGeral+"/projetos/sprints",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
          $('#modal_loader').addClass('hidden');
      });
    }
      });
  });

  $(document).on('click', '#hist-sprint', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/historias",
        type: 'POST',
        data: {id:id, tipo:'sprint'},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'60%');
           $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
      });
  });

  $(document).on('click', '#hist-proj', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/historias",
        type: 'POST',
        data: {id:id, tipo:'projeto'},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'60%');
           $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
      });
  });

  $(document).on('click', '.criar-historia', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var tipo = $(this).attr('data-tipo');
     $.ajax({
        url: urlbaseGeral+"/projetos/criarHistoria",
        type: 'POST',
        data: {id:id, tipo:tipo},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'30%');
      });
  });

    $(document).on('click', '#editar-historia', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
     var tipo = $(this).attr('data-tipo');
     $.ajax({
        url: urlbaseGeral+"/projetos/editarHistoria",
        type: 'POST',
        data: {id:id, tipo:tipo},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'30%');

      });
  });

    $(document).on('submit', '#historia_editar', function(event) {
    event.preventDefault();
    $('#modal_loader').removeClass('hidden');
    var values = $(this).serializeAndEncode();
    
    $.ajax({
      url: urlbaseGeral+"/projetos/updateHistoria",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    }).done(function(r){
       if(isKanban == true){
         $('#modal_loader').removeClass('hidden'); 
         location.reload();
       }else{
      flashMessage(r.status, r.msg);
        $.ajax({
        url: urlbaseGeral+"/projetos/historias",
        type: 'POST',
        data: {id:r.id, tipo: r.tipo},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
          $('#modal_loader').addClass('hidden');
      });
    }
    })
  });

    $(document).on('click', '#excluir-historia', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var tipo = $(this).attr('data-tipo');
     $.ajax({
        url: urlbaseGeral+"/projetos/excluirHistoria",
        type: 'POST',
        data: {id:id, tipo:tipo},
        dataType: 'json',
      })
      .done(function(r) {
       if(isKanban == true){
         $('#modal_loader').removeClass('hidden'); 
         location.reload();
       }else{
       flashMessage(r.status, r.msg);
        var sid = r.id;
        $.ajax({
        url: urlbaseGeral+"/projetos/historias",
        type: 'POST',
        data: {id:sid, tipo:r.tipo},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
          $('#modal_loader').addClass('hidden');
      });
    }
      });
  });

      $(document).on('click', '.projeto-disciplinas', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
      $.ajax({
        url: urlbaseGeral+"/projetos/disciplinas",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
      });
  });

  $(document).on('click', '.criar-disciplina', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/criarDisciplinas",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'30%');
      });
  });

      $(document).on('click', '#editar-disciplina', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/editarDisciplinas",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'30%');
      });
  });

  $(document).on('submit', '#editar_disciplina', function(event) {
    event.preventDefault();
    $('#modal_loader').removeClass('hidden');
    var values = $(this).serializeAndEncode();
    
    $.ajax({
      url: urlbaseGeral+"/projetos/updateDisciplinas",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    }).done(function(r){
      flashMessage(r.status, r.msg);
        $.ajax({
        url: urlbaseGeral+"/projetos/disciplinas",
        type: 'POST',
        data: {id:r.id},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
          $('#modal_loader').addClass('hidden');
      });
    })
  });

  $(document).on('click', '#excluir-disciplina', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/excluirDisciplinas",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      })
      .done(function(r) {
       flashMessage(r.status, r.msg);
      $.ajax({
       url: urlbaseGeral+"/projetos/disciplinas",
        type: 'POST',
        data: {id:r.id},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
          $('#modal_loader').addClass('hidden');
      });
      });
  });

  ///////

  $(document).on('click', '.projeto-etapas', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
      $.ajax({
        url: urlbaseGeral+"/projetos/etapas",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
      });
  });

  $(document).on('click', '.criar-etapa', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/criarEtapas",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'30%');
      });
  });

      $(document).on('click', '#editar-etapa', function(event) {
    event.preventDefault();
     var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/editarEtapas",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      })
      .done(function(response) {
        drawModal(response,'30%');
      });
  });

  $(document).on('submit', '#editar_etapa', function(event) {
    event.preventDefault();
    $('#modal_loader').removeClass('hidden');
    var values = $(this).serializeAndEncode();
    
    $.ajax({
      url: urlbaseGeral+"/projetos/updateEtapas",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    }).done(function(r){
      flashMessage(r.status, r.msg);
        $.ajax({
        url: urlbaseGeral+"/projetos/etapas",
        type: 'POST',
        data: {id:r.id},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
          $('#modal_loader').addClass('hidden');
      });
    })
  });

  $(document).on('click', '#excluir-etapa', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/excluirEtapas",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      })
      .done(function(r) {
       flashMessage(r.status, r.msg);
      $.ajax({
       url: urlbaseGeral+"/projetos/etapas",
        type: 'POST',
        data: {id:r.id},
        dataType: 'html',
      })
      .done(function(response) {
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'60%');
         $('#modalTable').DataTable({
            responsive: true,
            "iDisplayLength": 25,
        });
          $('#modal_loader').addClass('hidden');
      });
      });
  });

  $(document).on('click', '.projeto-delete', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/excluir",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      }).done(function(r){
        flashMessage(r.status, r.msg);
        if(r.status == 'success'){
          $('#projetosTable').DataTable().ajax.reload();
          $('#modal').modal('hide');
        }
      });
  });

    $(document).on('click', '#drop-estagio', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral + "/projetos/conf/estagios",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      }).done(function(response){
        drawModal(response,'30%');
          $("#sorEstagiosBody").sortable({
        tolerance: 'pointer',
       placeholder: "placeholderWrapper2",
        axis: "y",
         cursor: "move",
         revert: true,
        forceHelperSize: true,
        forcePlaceholderSize: true,
        helper: 'clone',
        start: function( event, ui ) {
          $('.excluir-conf-estag').addClass('hidden');
        },
         stop: function( event, ui ) {
          $('.excluir-conf-estag').removeClass('hidden');
          var sorted = $( "#sorEstagiosBody" ).sortable( "toArray", { attribute: 'data-id' } );
          $.ajax({
         url: urlbaseGeral+"/projetos/conf/setOrder",
         type: 'POST',
        data: {sorted:sorted},
        })
        },
    });
      });
  });

 $(document).on('click', '.edit-conf-estag', function(event) {
   event.preventDefault();
   $(this).addClass('hidden');
   $(this).parent('td').find('.edit-conf-form').removeClass('hidden');
 });

 $(document).on('submit', '.edit-conf-form', function(event) {
   event.preventDefault();
   var form = $(this);
   var values = $(this).serializeAndEncode();
      $.ajax({
      url: urlbaseGeral+"/projetos/conf/estagioEdit",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    })
    .done(function(r) {
      flashMessage(r.status, r.msg);
      if(r.status == 'success'){
        var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/estagios",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'30%');
        $("#sorEstagiosBody").sortable({
        tolerance: 'pointer',
       placeholder: "placeholderWrapper2",
        axis: "y",
         cursor: "move",
         revert: true,
        forceHelperSize: true,
        forcePlaceholderSize: true,
        helper: 'clone',
        start: function( event, ui ) {
          $('.excluir-conf-estag').addClass('hidden');
        },
         stop: function( event, ui ) {
          $('.excluir-conf-estag').removeClass('hidden');
          var sorted = $( "#sorEstagiosBody" ).sortable( "toArray", { attribute: 'data-id' } );
          $.ajax({
         url: urlbaseGeral+"/projetos/conf/setOrder",
         type: 'POST',
        data: {sorted:sorted},
        })
        },
    });
      });
    };
      
    });
 });

 $(document).on('click', '.hide-conf-edit-estag', function(event) {
   event.preventDefault();
    $(this).parent('form').parent('td').find('.edit-conf-estag').removeClass('hidden');
    $(this).parent('form').addClass('hidden');
 });

 $(document).on('click', '.create-conf-estag', function(event) {
   event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/conf/estagioNovo",
        type: 'POST',
        dataType: 'html',
        data:{id:id},
      })
      .done(function(response) {
        drawModal(response, '30%');
      });
 });


  $(document).on('click', '.excluir-conf-estag', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/conf/estagioExcluir",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      })
      .done(function(r) {
       flashMessage(r.status, r.msg);
       if(r.status == 'success'){
        var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/estagios",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'30%');
        $("#sorEstagiosBody").sortable({
        tolerance: 'pointer',
       placeholder: "placeholderWrapper2",
        axis: "y",
         cursor: "move",
         revert: true,
        forceHelperSize: true,
        forcePlaceholderSize: true,
        helper: 'clone',
        start: function( event, ui ) {
          $('.excluir-conf-estag').addClass('hidden');
        },
         stop: function( event, ui ) {
          $('.excluir-conf-estag').removeClass('hidden');
          var sorted = $( "#sorEstagiosBody" ).sortable( "toArray", { attribute: 'data-id' } );
          $.ajax({
         url: urlbaseGeral+"/projetos/conf/setOrder",
         type: 'POST',
        data: {sorted:sorted},
        })
        },
    });
         var sorted = $( "#sorEstagiosBody" ).sortable( "toArray", { attribute: 'data-id' } );
          $.ajax({
         url: urlbaseGeral+"/projetos/conf/setOrder",
         type: 'POST',
        data: {sorted:sorted},
        })
      });
    };
      });
  });

  $(document).on('click', '#drop-st-projeto', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral + "/projetos/conf/stProjeto",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      }).done(function(response){
        drawModal(response,'30%');
      });
    });

   $(document).on('click', '.create-conf-status', function(event) {
   event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/conf/stNovo",
        type: 'POST',
        dataType: 'html',
        data:{id:id},
      })
      .done(function(response) {
        drawModal(response, '30%');
      });
 });

    $(document).on('click', '.edit-conf-status', function(event) {
   event.preventDefault();
   $(this).addClass('hidden');
   $(this).parent('td').find('.edit-conf-status-form').removeClass('hidden');
 });

 $(document).on('click', '.hide-conf-edit-status', function(event) {
    event.preventDefault();
    $(this).parent('form').parent('td').find('.edit-conf-status').removeClass('hidden');
    $(this).parent('form').addClass('hidden');
 });

 $(document).on('submit', '.edit-conf-status-form', function(event) {
   event.preventDefault();
   var form = $(this);
   var values = $(this).serializeAndEncode();
      $.ajax({
      url: urlbaseGeral+"/projetos/conf/stEdit",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    })
    .done(function(r) {
      flashMessage(r.status, r.msg);
      if(r.status == 'success'){
        var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/stProjeto",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'30%');
      });
    };
      
    });
 });

   $(document).on('click', '.excluir-conf-status', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/conf/stExcluir",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      })
      .done(function(r) {
       flashMessage(r.status, r.msg);
       if(r.status == 'success'){
        var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/stProjeto",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'30%');
      });
    };
      });
  });

   ////////

    $(document).on('click', '#drop-st-tarefa', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral + "/projetos/conf/srTarefa",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      }).done(function(response){
        drawModal(response,'30%');
      });
    });

   $(document).on('click', '.create-conf-tarefa', function(event) {
   event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/conf/srNovo",
        type: 'POST',
        dataType: 'html',
        data:{id:id},
      })
      .done(function(response) {
        drawModal(response, '30%');
      });
 });

    $(document).on('click', '.edit-conf-tarefa', function(event) {
   event.preventDefault();
   $(this).addClass('hidden');
   $(this).parent('td').find('.edit-conf-tarefa-form').removeClass('hidden');
 });

 $(document).on('click', '.hide-conf-edit-tarefa', function(event) {
    event.preventDefault();
    $(this).parent('form').parent('td').find('.edit-conf-tarefa').removeClass('hidden');
    $(this).parent('form').addClass('hidden');
 });

 $(document).on('submit', '.edit-conf-tarefa-form', function(event) {
   event.preventDefault();
   var form = $(this);
   var values = $(this).serializeAndEncode();
      $.ajax({
      url: urlbaseGeral+"/projetos/conf/srEdit",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    })
    .done(function(r) {
      flashMessage(r.status, r.msg);
      if(r.status == 'success'){
        var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/srTarefa",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'30%');
      });
    };
      
    });
 });

   $(document).on('click', '.excluir-conf-tarefa', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/conf/srExcluir",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      })
      .done(function(r) {
       flashMessage(r.status, r.msg);
       if(r.status == 'success'){
        var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/srTarefa",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'30%');
      });
    };
      });
  });


   /////////

      $(document).on('click', '#drop-tarefa', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral + "/projetos/conf/tpTarefa",
        type: 'POST',
        data: {id:id},
        dataType: 'html',
      }).done(function(response){
        drawModal(response,'30%');
      });
    });

      $(document).on('click', '.fire-bckt-change', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    dd(id);
    $.ajax({
      url: urlbaseGeral+"/projetos/conf/setColor",
      type: 'POST',
      data:{id:id},
      dataType: 'html',
      })
      .done(function(response) {
        drawModal(response, '25%');
        $('.colorPickBck').colorpicker();
        $('.colorPickBck').colorpicker().on('changeColor.colorpicker', function(event){
          var color = event.color.toHex();
        $('#colorSelected').css('background', color);
      });
    
      });
  });

     $(document).on('submit', '#trocar_cor_proj', function(event) {
      event.preventDefault();
      var values = $(this).serializeAndEncode();
      $.ajax({
        url: urlbaseGeral+"/projetos/conf/storeColor",
        data: {dados: values},
        type: 'POST',
        dataType: 'json',
      }).done(function(r){
        flashMessage(r.status, r.msg);
        if(r.status == 'success'){
          var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/tpTarefa",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'25%');
      });
        }
      })
     });

     $(document).on('click', '.icon-tp-change', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
      url: urlbaseGeral+"/projetos/conf/setIcon",
      type: 'POST',
      data:{id:id},
      dataType: 'html',
      })
      .done(function(response) {
        drawModal(response, '25%');
      });
  });

         $(document).on('submit', '#trocar_icone_proj', function(event) {
      event.preventDefault();
      var formData = new FormData(this);
       $.ajax({
            type:'POST',
            url: urlbaseGeral+"/projetos/conf/storeIcon",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
        }).done(function(r) {
        flashMessage(r.status, r.msg);
        if(r.status == 'success'){
         var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/tpTarefa",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'25%');
      });
        }
      });
    });

  $(document).on('click', '.create-conf-tipoTarefa', function(event) {
   event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/conf/ttCreate",
        type: 'POST',
        dataType: 'html',
        data:{id:id},
      })
      .done(function(response) {
        drawModal(response, '30%');
      });
 });

     $(document).on('click', '.excluir-conf-tipoTarefa', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
     $.ajax({
        url: urlbaseGeral+"/projetos/conf/ttExcluir",
        type: 'POST',
        data: {id:id},
        dataType: 'json',
      })
      .done(function(r) {
       flashMessage(r.status, r.msg);
       if(r.status == 'success'){
        var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/tpTarefa",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'30%');
      });
    };
      });
  });

 $(document).on('click', '.edit-conf-tipoTarefa', function(event) {
   event.preventDefault();
   $(this).addClass('hidden');
   $(this).parent('td').find('.edit-conf-tipoTarefa-form').removeClass('hidden');
 });

 $(document).on('click', '.hide-conf-edit-tipoTarefa', function(event) {
    event.preventDefault();
    $(this).parent('form').parent('td').find('.edit-conf-tipoTarefa').removeClass('hidden');
    $(this).parent('form').addClass('hidden');
 });

  $(document).on('submit', '.edit-conf-tipoTarefa-form', function(event) {
   event.preventDefault();
   var form = $(this);
   var values = $(this).serializeAndEncode();
      $.ajax({
      url: urlbaseGeral+"/projetos/conf/ttEdit",
      data: {dados: values},
      type: 'POST',
      dataType: 'json',
    })
    .done(function(r) {
      flashMessage(r.status, r.msg);
      if(r.status == 'success'){
        var sid = r.id;
         $.ajax({
        url: urlbaseGeral + "/projetos/conf/tpTarefa",
        type: 'POST',
        data: {id:sid},
        dataType: 'html',
      }).done(function(response){
        window.modal_history.pop();
        window.modal_width.pop();
        drawModal(response,'30%');
      });
    };
      
    });
 });


 });

function kanbanReload(){
 if(isKanban == true){
  $('#loader').removeClass('hidden'); 
  location.reload();
 }
}