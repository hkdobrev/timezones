'use strict';

angular.module('timezones.controllers')
  .controller('TimezonesCtrl', [
    '$scope',
    'Timezone',
    function($scope, Timezone) {
      $scope.timezones = Timezone.query();
    }
  ]);
