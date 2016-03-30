 $(document).ready(function(){

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

 });