'use strict';

angular.module('timezones.controllers')
  .controller('LoginCtrl', [
    '$scope',
    '$auth',
    '$rootScope',
    function($scope, $auth, $rootScope) {
      $scope.submit = function() {
        $auth.login({
          username: $scope.username,
          password: $scope.password,
          scope: 'timezones'
        });
      };
    }
  ]);
