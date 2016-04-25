$(document).ready(function() {
	 var canal = 'kanban-'+thisProjetoId;
  if(app_env == 'local')
    var socket = io(':3000');
  else
    var socket = io('http://steel4web.com.br:3000');
  socket.on(canal, function(data) {
     var dados = data.data.data.message;
     if(dados.user != thisUserId){
     	flashInfoCenter(dados.notify);
     	moveTask(dados.task,parseInt(dados.est));
     }
    });
});