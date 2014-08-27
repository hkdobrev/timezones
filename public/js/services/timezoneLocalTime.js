'use strict';

angular.module('timezones.services')
  .factory('timezoneLocalTime', [
    function () {
      return function(utcOffsetInHours) {
        // create Date object for current locale
        var currentLocaleDate = new Date();

        // convert to ms
        // subtract local time zone offset
        // get UTC time in ms
        var utcInMilliseconds = currentLocaleDate.getTime() - (currentLocaleDate.getTimezoneOffset() * 60000);

        // create new Date object for the specified offset
        return new Date(utcInMilliseconds + (3600000 * utcOffsetInHours));
      };
    }
  ]);
