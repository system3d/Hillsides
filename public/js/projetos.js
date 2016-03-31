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
            { "data": "status" }
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

 });