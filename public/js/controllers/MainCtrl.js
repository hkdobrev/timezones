'use strict';

angular.module('timezones.controllers')
  .controller('MainCtrl', [
    '$scope',
    '$auth',
    function($scope, $auth) {
      $scope.logout = function() {
        $auth.logout();
      };
    }
  ])

