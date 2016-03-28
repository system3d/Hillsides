function getProjetoCadastro(){
	$('#loader').removeClass('hidden'); 
	$.ajax({
	    url: urlbaseGeral+"/cadastro/projeto",
	    type: 'POST',
	    dataType: 'html',
	  })
	  .done(function(response) {
	  	drawModal(response);
	  });
	$('#loader').addClass('hidden'); 
}

function getClienteCadastro(){
	$('#loader').removeClass('hidden'); 
	$.ajax({
	    url: urlbaseGeral+"/cadastro/cliente",
	    type: 'POST',
	    dataType: 'html',
	  })
	  .done(function(response) {
	  	drawModal(response);
	  });
	$('#loader').addClass('hidden'); 
}

function drawModal(data){
	$('#modal-content').html(data);
  	$('#modal').modal("show");
}

 $(document).ready(function(){
 	$(document).on('submit', '.modal_form', function(event) {
 		$('#modal_loader').removeClass('hidden');
 		var values = $(this).serializeAndEncode();
 		event.preventDefault();
 		$.ajax({
	    url: urlbaseGeral+"/cadastro/store",
	    data: {dados: values},
	    type: 'POST',
	    dataType: 'html',
	  })
	  .done(function(rp) {
	  	$('#modal').modal("hide");
	  	var rex = rp.split('%');
	  	r =  rex[1];
	  	var res = r.split("&");
        flashMessage(res[0], res[1]);
        if(res[2]){
        	if(res[2] == 'C'){
        		$('#clientesTable').DataTable().ajax.reload();
        	}
        }
        $('#modal_loader').addClass('hidden');
	  });
 	});
 });