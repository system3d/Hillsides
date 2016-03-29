 $(document).ready(function(){

 	 var clientesTable = $('#equipesTable').DataTable({
            ajax: {
              type: 'GET',
              url: urlbaseGeral+"/equipes/getEquipes",
            },
            responsive: true,
            columns:  [
            { "data": "nome" },
            { "data": "obs"},
            { "data": "resp" },
            { "data": "memb" },
        ],
        "iDisplayLength": 25,
            "language": {
              "emptyTable": "Nenhuma Equipe Cadastrada."
            },
        });

 	 $(document).on('click', '.equipe-info', function(event) {
 		var id = event.target.id;
 		$.ajax({
		    url: urlbaseGeral+"/equipes/info",
		    type: 'POST',
		    data: {id:id},
		    dataType: 'html',
		  })
		  .done(function(response) {
		  	drawModal(response, '40%');
            modal_history = response;
            modal_width = '40%';
		  });
 	});

     $(document).on('click', '.info-edit-equipe', function(event) {
        var id = event.target.id;
        $.ajax({
            url: urlbaseGeral+"/equipes/editar",
            type: 'POST',
            data: {id:id},
            dataType: 'html',
          })
          .done(function(response) {
            drawModal(response, '30%');
          });
    });

     $(document).on('click', '#criarEquipe', function(event) {
         event.preventDefault();
         $('#loader').removeClass('hidden'); 
         $.ajax({
            url: urlbaseGeral+"/equipes/criar",
            type: 'POST',
            dataType: 'html',
          })
          .done(function(response) {
            drawModal(response, '30%');
          });
        $('#loader').addClass('hidden'); 
         });

     $(document).on('submit', '#equipe_atualizar', function(event) {
        $('#modal_loader').removeClass('hidden');
        var values = $(this).serializeAndEncode();
        event.preventDefault();
        $.ajax({
        url: urlbaseGeral+"/equipes/update",
        data: {dados: values},
        type: 'POST',
        dataType: 'html',
      }).done(function(rp){
        $('#modal').modal("hide");
        var rex = rp.split('%');
        r =  rex[1];
        var res = r.split("&");
        flashMessage(res[0], res[1]);
        $('#modal_loader').addClass('hidden');
        $('#equipesTable').DataTable().ajax.reload();
      })
    });

     $(document).on('click', '.equipe-delete', function(event){
        $('#modal_loader').removeClass('hidden');
        var id = event.target.id;
        $.ajax({
        url: urlbaseGeral+"/equipes/delete",
        data: {id: id},
        type: 'POST',
        dataType: 'html',
      }).done(function(rp){
        $('#modal').modal("hide");
        var rex = rp.split('%');
        r =  rex[1];
        var res = r.split("&");
        flashMessage(res[0], res[1]);
        $('#modal_loader').addClass('hidden');
        $('#equipesTable').DataTable().ajax.reload();
      })
    });

     $(document).on('click', '#equipe-novo-membro', function(event) {
         event.preventDefault();
         $('#equipe-novo-membro').addClass('hidden');
         $('#novo-membro-wrapper').removeClass('hidden');
     });

     $(document).on('click', '#close-membro', function(event) {
         event.preventDefault();
        $('#equipe-novo-membro').removeClass('hidden');
         $('#novo-membro-wrapper').addClass('hidden');
     });

     $(document).on('click', '.remover-membro', function(event) {
         event.preventDefault();
         var id = $(this).attr('data-id');
         var equipe_id = $(this).attr('data-equipe-id');
          $.ajax({
        url: urlbaseGeral+"/equipes/removerMembro",
        data: {id: id, equipe_id: equipe_id},
        type: 'POST',
        dataType: 'json',
      }).done(function(rp){
        var rex = rp.msg.split('%');
        r =  rex[1];
        var res = r.split("&");
        flashMessage(res[0], res[1]);
        var eid = rp.id;
        $.ajax({
            url: urlbaseGeral+"/equipes/info",
            type: 'POST',
            data: {id:eid},
            dataType: 'html',
          })
          .done(function(response) {
            drawModal(response, '40%');
            modal_history = response;
            modal_width = '40%';
            $('#equipesTable').DataTable().ajax.reload();
          });
      });
     });

     $(document).on('click', '#save-membro', function(event) {
         event.preventDefault();
         $(this).find('i').removeClass('fa-check');
         $(this).find('i').addClass('fa-spinner');
         $(this).find('i').addClass('fa-spin');
         var id = $('#novo-membro').val();
         var equipe_id = $('#novo-membro').attr('data-equipe-id');
          $.ajax({
        url: urlbaseGeral+"/equipes/novoMembro",
        data: {id: id, equipe_id: equipe_id},
        type: 'POST',
        dataType: 'json',
      }).done(function(rp){
        var rex = rp.msg.split('%');
        r =  rex[1];
        var res = r.split("&");
        flashMessage(res[0], res[1]);
        var eid = rp.id;
        $.ajax({
            url: urlbaseGeral+"/equipes/info",
            type: 'POST',
            data: {id:eid},
            dataType: 'html',
          })
          .done(function(response) {
            drawModal(response, '40%');
            modal_history = response;
            modal_width = '40%';
            $('#equipesTable').DataTable().ajax.reload();
          });
      });
     });

 });