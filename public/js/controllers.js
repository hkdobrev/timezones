'use strict';

/* Controllers */

angular.module('timezones.controllers', [])
  .controller('LoginCtrl', [
    '$scope',
    '$auth',
    function($scope, $auth) {

      function authenticate(username, password) {
        $auth.login({
          username: $scope.username,
          password: $scope.password,
          scope: 'timezones'
        });
      }

      $scope.submit = function() {
        authenticate($scope.username, $scope.password);
      };
    }
  ]);
