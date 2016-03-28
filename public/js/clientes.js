 $(document).ready(function(){

 	 var clientesTable = $('#clientesTable').DataTable({
            ajax: {
              type: 'GET',
              url: urlbaseGeral+"/cadastro/getClientes",
            },
            responsive: true,
            columns:  [
            { "data": "razao" },
            { "data": "fantasia"},
            { "data": "telefone" },
            { "data": "cidade" },
            { "data": "endereco" }
        ],
        "iDisplayLength": 25,
            "language": {
              "emptyTable": "Nenhum Cliente Cadastrado."
            },
        });

 	$(document).on('click', '#cadastrarCliente', function(event) {
 		getClienteCadastro();
 	});

 	$(document).on('click', '.info-edit-cliente', function(event) {
 		var id = event.target.id;
 		$.ajax({
		    url: urlbaseGeral+"/cadastro/clienteEdit",
		    type: 'POST',
		    data: {id:id},
		    dataType: 'html',
		  })
		  .done(function(response) {
		  	drawModal(response);
		  });
 	});

 	$(document).on('click', '.cliente-info', function(event) {
 		var id = event.target.id;
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

 	$(document).on('submit', '#cliente_atualizar', function(event) {
 		$('#modal_loader').removeClass('hidden');
 		var values = $(this).serializeAndEncode();
 		event.preventDefault();
 		$.ajax({
	    url: urlbaseGeral+"/cadastro/clienteUpdate",
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
        $('#clientesTable').DataTable().ajax.reload();
	  })
 	});

 	$(document).on('click', '.cliente-delete', function(event){
 		$('#modal_loader').removeClass('hidden');
 		var id = event.target.id;
 		$.ajax({
	    url: urlbaseGeral+"/cadastro/clienteDelete",
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
        $('#clientesTable').DataTable().ajax.reload();
	  })
 	});
 });