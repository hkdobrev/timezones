'use strict';

angular.module('timezones.resources')
  .factory('Timezone', [
    '$resource',
    function ($resource) {
      return $resource('timezones');
    }
  ]);
