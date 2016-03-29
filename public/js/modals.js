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

function drawModal(data, widtth){
	var wideth =  widtth != undefined ? widtth : '60%';
	$('#modal-content').parent('.modal-dialog').css('width', wideth);
	$('#modal-content').html(data);
  	$('#modal').modal("show");
}

 $(document).ready(function(){

 	$(document).on('click', '#voltar_modal', function(event) {
 		event.preventDefault();
 		if(modal_history){
 			$('#modal-content').parent('.modal-dialog').css('width', modal_width);
 			$('#modal-content').html(modal_history);
 		}else
		$('#modal').modal("hide");
 	});

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
        	}else if(res[2] == 'E'){
        		$('#equipesTable').DataTable().ajax.reload();
        	}
        }
        $('#modal_loader').addClass('hidden');
	  });
 	});
 });