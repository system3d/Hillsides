 $(document).ready(function(){

    var canal = 'teste';

   $(document).on('submit', '#projeto_cadastro', function(event) {
   	event.preventDefault();
   	dd('feiheoug');
   });
     if(app_env == "local")
	    var socket = io(':3000');
	  else
	    var socket = io('http://steel4web.com.br:3000');
 	 socket.on(canal, function(data) {
      dd(data);
    });

 	 $('.testedo').click(function(event) {

	getClienteCadastro();
});

});