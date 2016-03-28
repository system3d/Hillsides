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
		  	drawModal(response);
		  });
 	});

 
 });