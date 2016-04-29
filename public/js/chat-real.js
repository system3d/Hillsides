$(document).ready(function() {
	 var canal = 'message-'+thisUserId;
   var canalStatus = 'chat-misc-status-'+thisLocatarioId;
   var canalStatusOffline = 'chat-misc-status-offline-'+thisLocatarioId;
   var canalTyp = 'typing-'+thisUserId;
  if(app_env == 'local')
    var socket = io(':3000');
  else
    var socket = io('http://steel4web.com.br:3000');

     socket.on(canal, function(data) {
       var dados = data.data.data.message;
       appendRealMessage(dados);
    });

      socket.on(canalTyp, function(data) {
       var rec = data.receiver;
       setTyping(rec);
    });

    socket.on(canalStatus, function(data) { 
        var id = data.data.data.message.params;
        changeToOnline(id);
        $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').attr('data-time', 1);
        $('.chat_user[data-id="'+id+'"]').attr('data-off', 'false');
    });

    socket.on(canalStatusOffline, function(data) {
       var id = data.data.data.message.params;
       $('.chat_user[data-id="'+id+'"]').attr('data-off', 'true');
       changeToTime(id);
    });


     $(document).on('keydown', '.chat-text-area', function(event) {
      var rec = $(this).attr('data-id');
        if(event.which == 13) {
              event.preventDefault();
              var text = $(this);
        var msg = text.val();
        
        if(msg != ''){
          $.ajax({
            url: urlbaseGeral + '/chat/send',
            type: 'POST',
            dataType: 'json',
            data: {msg: msg,receiver:rec},
          })
          .done(function(r) {
            if(r.status == 0 || r.status == 3){
              insertMsg(r.id,r.msg,r.name,r.time,r.status,r.receiver,0);
              text.val('');
            }
          });
        }
        }else{
         socket.emit("typing", {sender: thisUserId,receiver:rec});
        }
    });

});


setInterval(function(){ 
  autoUpdateStatus();
}, 60000);


function appendRealMessage(dados){
  if(!$('.chat-window[data-id="'+dados.sender+'"]').length){
    createChatWindow(dados.receiver,dados.sender);
  }else{
    var header = dados.header;
    insertMsg(header.id,dados.message,header.name,header.date,header.status,dados.sender,1);
       $('.chat-window[data-id="'+dados.sender+'"]').removeClass('collapsed-box');
       $('.chat-window[data-id="'+dados.sender+'"]').find('.box-body').css('display', 'block');
       $('.chat-window[data-id="'+dados.sender+'"]').find('.box-footer').css('display', 'block');
       var thisWindow = $('.chat-window[data-id="'+dados.sender+'"]').find('.direct-chat-messages');
       thisWindow.scrollTop(thisWindow.prop('scrollHeight'));
       $('.istiping-block[data-id="'+dados.sender+'"]').addClass("visNone");
  }
  
}

var typing = false; 
function setTyping(rec){
  if($('.chat-window[data-id="'+rec+'"]').length){
    if(!typing){
       $('.istiping-block[data-id="'+rec+'"]').removeClass('visNone');
       setTimeout(function(){
        typing = false;
      }, 3000);
       typing = true;
    }

    setTimeout(function(){
       if(!typing){
        $('.istiping-block[data-id="'+rec+'"]').addClass("visNone");
      }
      }, 3000);
    
 }
}

function changeToOnline(id){
  var statusHtml = $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').html('<i class="fa fa-circle text-success"></i> Online');
  var thisUser = $('.chat_user[data-id="'+id+'"]');
  var userHTML = thisUser.html();
  thisUser.remove();
  $('#chat_menu_list').prepend(thisUser);
}

function changeToOffline(id){
  var statusHtml = $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').html('<i class="fa fa-circle text-danger"></i> Offline');
  var thisUser = $('.chat_user[data-id="'+id+'"]');
  var userHTML = thisUser.html();
  thisUser.remove();
  $('#chat_menu_list').append(thisUser);
}

function changeToTime(id){
  var st_time = $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').attr('data-time');
  var timeHtml = getTimeHtml(st_time);
  $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').html(timeHtml);
  var thisUser = $('.chat_user[data-id="'+id+'"]');
  var userHTML = thisUser.html();
  thisUser.remove();
  $('#chat_menu_list').append(thisUser);
}

function changeToFive(id){
  var statusHtml = $('.chat_user[data-id="'+id+'"]').find('.chat_user_status').html('Visto(a) por último à 5 minutos');
   var thisUser = $('.chat_user[data-id="'+id+'"]');
  var userHTML = thisUser.html();
  thisUser.remove();
  $('#chat_menu_list').append(thisUser);
}

function autoUpdateStatus(){
  var users = $('#chat_menu_list').find('.chat_user');
  users.each(function(index, el) {
    var statusTag = $(el).find('.chat_user_status');
    var id = $(el).attr('data-id');
    var isOff = $(el).attr('data-off');
    var st_time = statusTag.attr('data-time');
    if(st_time > 0){
       var new_time = parseInt(st_time) + 60;
    statusTag.attr('data-time', new_time);
    if(new_time > 86400 && st_time < 86400){
      changeToOffline(id);
    }
    if(new_time > 300 && new_time < 86400  || isOff == 'true'){
       var timeHtml = getTimeHtml(new_time);
       statusTag.html(timeHtml);
    }
   
    }
  });
}

function getTimeHtml(s){
  var obj = secondsToTime(s);
  var response = s;
  if(obj.h > 0){
    if(obj.h == 1)
      response = 'Visto(a) por último à 1 hora';
    else
      response = 'Visto(a) por último à '+obj.h+' horas';
  }else if(obj.m > 0){
    if(obj.m == 1)
      response = 'Visto(a) por último à 1 minuto';
    else
      response = 'Visto(a) por último à '+obj.m+' minutos';
  }else if(obj.s > 0){
      response = 'Visto(a) por último à 1 minuto';
  }else{
    response = '<i class="fa fa-circle text-danger"></i> Offline';
  }
  return response;
}