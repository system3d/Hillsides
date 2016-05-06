var ChatApp = angular.module('ChatApp', ['ngRoute']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

var ChatCtrl = ChatApp.controller("ChatCtrl",[ '$scope', '$http', function($scope, $http) {
  $scope.urlBase = window.urlbaseGeral;
  $scope.thisUserId = window.thisUserId;

    $scope.initChat = function() {
      $http.post($scope.urlBase+"/messages/getUsers")
      .then(function(response) {
          $scope.users = response.data;
      });

      $http.post($scope.urlBase+"/messages/getMessages")
      .then(function(response) {
          $scope.messages = response.data;
      });
    }

}]);