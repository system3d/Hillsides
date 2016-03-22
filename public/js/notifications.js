 $(document).ready(function(){

    RefreshClick();

    printDropdown();

    ClearClick();

    DropDownDown();

    TableCall();

    DeleteRow();

});


function ListenSocketNewOld(){
   var socket = io(':3000');
  socket.on("user-" + thisUserId, function(data){
       message = JSON.parse(data);
      notify = message.data.data.message;
      $.toast({
        heading: notify.title,
        text: notify.message,
        hideAfter: 20000,
        icon: notify.type,
        showHideTransition: 'slide',
         position: { left : 'auto', right : 10, top : 'auto', bottom : 35 },
      });
      printDropdown();
       redrawNotifys();
 });
   socket.emit('subscribe', "user-" + thisUserId);
}

function ListenSocket(){
  var canal = 'user-'+thisUserId;
  if(app_env == 'local')
    var socket = io(':3000');
  else
    var socket = io('http://steel4web.com.br:3000');
  socket.on(canal, function(data) {
      var notify = data.data.data.message;
      $.toast({
        heading: notify.title,
        text: notify.message,
        hideAfter: 20000,
        icon: notify.type,
        showHideTransition: 'slide',
         position: { left : 'auto', right : 10, top : 'auto', bottom : 35 },
      });
      printDropdown();
       redrawNotifys();
    });
}

function printDropdown(){
  $('.notify_menu').find('li').remove().end();
  $('.labelNotys').remove().end();
  $.ajax({
    url: urlbaseGeral+"/notificacoes/listNots",
    type: 'GET',
    dataType: 'json',
  })
  .done(function(response) {
    $('.labelWrapper').removeClass('faa-ring animated');
    if(Object.keys(response).length > 0){
      var count = 0;
      var len = 0;
      var notifys = '';
      $.each(response, function (index, el){                   
        if(el.status == 0 || el.status == 1){
          len++;
          if(count <= 20){
            notifys = notifys + '<li id="notx'+el.id+'" class="singleNotify"><a href="'+urlbaseGeral+'/notificacao/'+el.id+'" class="not_read_yet"><i class="fa '+notIcon(el.tipo)+'"></i>'+el.titulo+'<small class="delete_notification pull-right" title="Dispensar Notificação"><i class="fa fa-times"></i></small><small style="font-size:8px"><br>'+diffForHumans(el.created_at,'d/m/y h:i')+' - '+el.autor+'</small></a></li>'
            count++;
          } 
        }
      });
      $.each(response, function (index, el){                   
        if(el.status == 2){
          if(count <= 20){
            notifys = notifys + '<li id="notx'+el.id+'" class="singleNotify"><a href="'+urlbaseGeral+'/notificacao/'+el.id+'"><i class="fa '+notIcon(el.tipo)+'"></i>'+el.titulo+'<small class="delete_notification pull-right" title="Dispensar Notificação"><i class="fa fa-times"></i></small><small style="font-size:8px"><br>'+diffForHumans(el.created_at,'d/m/y h:i')+' - '+el.autor+'</small></a></li>'
            count++;
          }
        }
      });
      if(len>0){
        $('.labelWrapper').after('<span class="labelNotys label label-info">'+len+'</span>');
        $('.labelWrapper').addClass('faa-ring animated');
      }
      
      $('.notify_menu').append(notifys);
      $.ajax({
         url: urlbaseGeral+"/notificacoes/status",
          type: 'POST',
         dataType: 'html',
         data: {all: true, listed: true}
        })
    }else{
      $('.notify_menu').append('<li style="text-align:center"><a href="#">Você não tem notificações</a></li>');
    }
  }) 
}

function notIcon(type) {
    switch (type) {
      case 'success':
        return 'fa-check text-green';
        break;
      case 'error':
        return 'fa-exclamation-triangle text-red';
        break;
      case 'warning':
        return 'fa-exclamation text-yellow';
        break;
      case 'info':
        return 'fa-info-circle text-aqua';
        break;
      default:
        return 'fa-flag';
        break;
    }
  }


if (!Object.keys) {
    Object.keys = function (obj) {
        var arr = [],
            key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) {
                arr.push(key);
            }
        }
        return arr;
    };
}

function RefreshClick(){

  $('#limparNotifys').off();

   $(document).on('click', '#limparNotifys', function(event) {

        $.ajax({
         url: urlbaseGeral+"/notificacoes/clear",
         type: 'POST',
         dataType: 'html',
          data: {clear: true},
          success: function(result){
            printDropdown();
            redrawNotifys();
          }
        })
      
        event.stopPropagation();
      });

}

function ClearClick(){
  $('.delete_notification').off();

   $(document).on('click', '.delete_notification', function(event) {
          event.preventDefault();
         var ind = $(this).closest('.singleNotify').attr('id');
         var ids = ind.split('x');
         var id = ids[1];
        $.ajax({
         url: urlbaseGeral+"/notificacoes/delete",
         type: 'POST',
         dataType: 'html',
          data: {id: id},
          success: function(result){
            printDropdown();
            redrawNotifys();
          }
        })
        // }).done(function() {
        //   $('.notify_dropdown').dropdown('toggle');
        // });
      //  dd('evento coisou');
      
        event.stopPropagation();
      });
}

function DropDownDown(){
  $('.notifications-menu').off();

   $(document).on('hidden.bs.dropdown', '.notifications-menu', function(event) {
        $.ajax({
         url: urlbaseGeral+"/notificacoes/status",
         type: 'POST',
         dataType: 'html',
          data: {all: true},
          success: function(result){
            $('.labelWrapper').removeClass('faa-ring animated');
            $('.singleNotify').find('a').removeClass('not_read_yet');
            $('.labelNotys').remove();
          }
        })
      });
}

function DeleteRow(){
  $(document).on('click', '.deleteListedNotify', function(event) {
    event.preventDefault();
    var ind = $(this).attr('id');
       var ids = ind.split('R');
       var id = ids[1];
      $.ajax({
       url: urlbaseGeral+"/notificacoes/delete",
       type: 'POST',
       dataType: 'html',
        data: {id: id},
        success: function(result){
          printDropdown();
          redrawNotifys();
          flashSuccess('Notificação Excluida com Sucesso!');
        }
      })
  });
}

function TableCall(){
   return $('#NotifyTable').DataTable({
            ajax: {
              type: 'GET',
              url: urlbaseGeral+"/notificacoes/getNots",
            },
            responsive: true,
            columns:  [
            { "data": "icon" },
            { "data": "title"},
            { "data": "msg" },
            { "data": "date" },
            { "data": "autor" },
            { "data": "action" },
        ],
        "iDisplayLength": 100,
        "retrieve": true,
        "ordering": false
    });
}

function redrawNotifys(){
  var table = TableCall();
 table.ajax.url(urlbaseGeral+"/notificacoes/getNots").load();
} 




// $(document).ready(function() {

   
//    Pusher.log = function(message) {
//       if (window.console && window.console.log) {
//         window.console.log(message);
//       }
//     };

//   var pusher = new Pusher('a39f21ceccb5ed40d1b7', {
//       encrypted: true
//     });

//  // Pusher.channel_auth_endpoint = '/presence_auth.php';

//     console.log(thisUserId);
//     var channel = pusher.subscribe("user-" + thisUserId);
//     channel.bind('my_event', function(data) {
//       console.log(data);
//       $('.notBox').addClass(data.type);
//       $('.notText').html(data.message);
//       $('.notTitle').html(data.title);
//       $('.notBox').fadeIn(400);
//     });

// });


// this.socket.on("user-" + thisUserId + ":App\\Events\\Eventname", function(data){
//     console.log(data);
//       $('.notBox').addClass(data.type);
//       $('.notText').html(data.message);
//       $('.notTitle').html(data.title);
//       $('.notBox').fadeIn(400);
//  });

// var sockete = io.connect('http://localhost:8890');
 
//             //socket.on('connect', function(data){
//             //    socket.emit('subscribe', {channel:'score.update'});
//             //});
 
//             sockete.on('user', function (data) {
//                 //Do something with data
//                 console.log('Score updated: ', data);
//             });