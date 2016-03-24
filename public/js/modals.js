function getProjetoCadastro(){
	$('#loader').removeClass('hidden'); 
	$.ajax({
	    url: urlbaseGeral+"/projetos/cadastro",
	    type: 'POST',
	    dataType: 'html',
	  })
	  .done(function(response) {
	  	$('#modal-content').html(response);
	  	$('#modal').modal("show");
	  });
	$('#loader').addClass('hidden'); 
}