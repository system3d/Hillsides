var ChatApp = angular.module('ChatApp', ['DateFilters']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});


var ChatCtrl = ChatApp.controller("ChatCtrl",[ '$scope', '$http', 'socket', '$timeout', function($scope, $http, socket, $timeout) {
  $scope.urlBase = window.urlbaseGeral;
  $scope.thisUserId = window.thisUserId;
  $scope.lastMessage = 0;
  $scope.activeUser = 0;
  $scope.isTyping = false;

    $scope.initChat = function() {
      $http.post($scope.urlBase+"/messages/getUsers")
      .then(function(response) {
          $scope.users = response.data;
          $scope.users = [];
          angular.forEach(response.data, function(element) {
            var thisId = element.id;
            $scope.users[thisId] = element;
          });
          angular.forEach($scope.users, function(user, key) {
          if(user.id != $scope.thisUserId  && !angular.isUndefined(user.last)){
            if($scope.lastMessage == 0){
              $scope.lastMessage = user.last.date;
              $scope.activeUser = user.id;
            }
            if(user.last.date > $scope.lastMessage){
              $scope.lastMessage = user.last.date;
              $scope.activeUser = user.id;
            }

            
         }
        });
          if($scope.activeUser != 0){
           $scope.changeActiveUser($scope.activeUser);
          }
      });
    }

    $scope.sendMessage = function(id,first) {
      if(!$scope.messageContent){
        flashMessage('warning','Mensagem sem Conteúdo.');
      }else{
        var todayJs = new Date();
        var today = formatDate(todayJs);
        var tempMsg = {
          'message'     : $scope.messageContent,
          'status'      : 0,
          'sender_id'   : $scope.thisUserId,
          'receiver_id' : $scope.activeUser,
          'created_at'  : today
        };
        $scope.messages.push(tempMsg);
        setTimeout(downWeGo, 0);
        var msgContent = $scope.messageContent;
        $scope.messageContent = '';
        $http({
          method: 'POST',
          url: $scope.urlBase+'/chat/send',
          data: {msg: msgContent,receiver:$scope.activeUser}
        });
      }
    }

  $scope.changeActiveUser = function(id,first) {
      if(angular.isArray(id)){
        $scope.activeUser = id[0][0];
      }else{
        $scope.activeUser = id;
      }
      $http.post($scope.urlBase+"/messages/getMessages",{id:id}).then(function(response) {
        $scope.messages = response.data;
        setTimeout(downWeGo, 0);
        $scope.users[$scope.activeUser].unreads = 0;
        markAsRead($scope.activeUser);
      });
  }

  $scope.setIsTyping = function($event){
    if($event.which != 13){
      socket.emit("typing", {sender: $scope.thisUserId,receiver:$scope.activeUser});
    }
  }

  $scope.sortUsers = function(user) {
    if(!angular.isUndefined(user.last)){
      var str = user.last.date.replace(/-/g,'/');
      str = str.split('.');
      var date = new Date(str[0]);
    }else{
    var date = new Date('1970-01-01');
    }
    return date;
};
    var canal = 'message-'+$scope.thisUserId;
    socket.on(canal, function(data) {
       var dados = data.data.data.message;
       if(dados.sender == $scope.activeUser){
          var tempMsg = {
            'message'     : dados.message,
            'status'      : 0,
            'sender_id'   : dados.sender,
            'receiver_id' : dados.receiver,
            'created_at'  : dados.header.created_at.date
          };
          $scope.messages.push(tempMsg);
          $scope.isTyping = false;
          setTimeout(downWeGo, 0);
          markAsRead(dados.sender);
       }else{
        angular.forEach($scope.users, function(user, key) {
          if(user.id == dados.sender){
            user.last.date = dados.header.created_at.date;
            user.unreads = parseInt(user.unreads) + 1;
          }
        });
       }
    });

  var canalTyp = 'typing-'+$scope.thisUserId;
  socket.on(canalTyp, function(data) {
     var rec = data.receiver;
     if(rec == $scope.activeUser){
      $scope.isTyping = true;
      $timeout(function() {
        $scope.isTyping = false;
    }, 3000);
     }
  });

}]);



angular.module('DateFilters', []).filter('date_br', function() {
  return function(input) {
    if(!angular.isUndefined(input)){
      var str = input.replace(/-/g,'/');
      str = str.split('.');
      var data = new Date(str[0]);
      var dia = data.getDate();
      if (dia.toString().length == 1)
        dia = "0"+dia;
      var mes = data.getMonth();
      var months = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
      var mes = months[mes];
      var horas = data.getHours();
      if(horas.toString().length == 1){
        horas = '0'+horas;
      }
      var mins = data.getMinutes();
      if(mins.toString().length == 1){
        mins = '0'+mins;
      }
      return dia+" "+mes+', '+horas+':'+mins;

    }else{
      return 'Nenhuma Mensagem';
    }
  }
});

ChatApp.directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown", function(e) {
            if(e.which === 13) {
                scope.$apply(function(){
                    scope.$eval(attrs.ngEnter, {'e': e});
                });
                e.preventDefault();
            }
        });
    };
});

ChatApp.factory('socket', function ($rootScope) {
  if(app_env == 'local')
    var socket = io(':3000');
  else
    var socket = io('http://steel4web.com.br:3000');
  return {
    on: function (eventName, callback) {
      socket.on(eventName, function () {  
        var args = arguments;
        $rootScope.$apply(function () {
          callback.apply(socket, args);
        });
      });
    },
    emit: function (eventName, data, callback) {
      socket.emit(eventName, data, function () {
        var args = arguments;
        $rootScope.$apply(function () {
          if (callback) {
            callback.apply(socket, args);
          }
        });
      })
    }
  };
});


function downWeGo(){
  var thisWindow2 = $('.msg-row').find('.msg-messages-content');
  thisWindow2.scrollTop(thisWindow2.prop('scrollHeight'));
};