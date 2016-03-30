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
            modal_history = response;
            modal_width = '50%';
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
            modal_history = response;
            modal_width = '50%';
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
 	
 });