var ChatApp = angular.module('ChatApp', ['DateFilters']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});


var ChatCtrl = ChatApp.controller("ChatCtrl",[ '$scope', '$http', function($scope, $http) {
  $scope.urlBase = window.urlbaseGeral;
  $scope.thisUserId = window.thisUserId;
  $scope.lastMessage = 0;
  $scope.activeUser = 0;

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
          if(user.id != $scope.thisUserId){
            if($scope.lastMessage == 0){
              $scope.lastMessage = user.last.date;
              $scope.activeUser = user.id;
            }
            if(user.last.date > $scope.lastMessage){
              $scope.lastMessage = user.last.date;
              $scope.activeUser = user.id;
            }

            if($scope.activeUser != 0){
             $scope.changeActiveUser($scope.activeUser);
            }
         }
        });
      });
    }

  $scope.changeActiveUser = function(id,first) {
      $scope.activeUser = id;
      $http.post($scope.urlBase+"/messages/getMessages",{id:id}).then(function(response) {
        $scope.messages = response.data;
        setTimeout(downWeGo, 0);
      });
  }

  $scope.sortUsers = function(user) {
    var date = new Date(user.last.date);
    return date;
};

}]);



angular.module('DateFilters', []).filter('date_br', function() {
  return function(input) {
    var data = new Date(input);
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
  };
});




function downWeGo(){
  var thisWindow2 = $('.msg-row').find('.msg-messages-content');
  thisWindow2.scrollTop(thisWindow2.prop('scrollHeight'));
};