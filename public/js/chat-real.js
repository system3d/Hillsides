$(document).ready(function() {
	 var canal = 'message-'+thisUserId;
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

var typing = false;  
var timeout = undefined;

