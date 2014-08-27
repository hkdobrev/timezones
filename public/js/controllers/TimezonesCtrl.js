'use strict';

angular.module('timezones.controllers')
  .controller('TimezonesCtrl', [
    '$scope',
    'Timezone',
    'timezoneLocalTime',
    function($scope, Timezone, timezoneLocalTime) {
      $scope.timezones = Timezone.query();
    }
  ]);
