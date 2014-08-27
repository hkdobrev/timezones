'use strict';

angular.module('timezones.filters')
  .filter('offsetToTime', [
    'timezoneLocalTime',
    function (timezoneLocalTime) {
      return function(utcOffsetInHours) {
        utcOffsetInHours = parseFloat(utcOffsetInHours);
        var convertedDate = timezoneLocalTime(utcOffsetInHours);
        
        return ((convertedDate.getHours() < 10 ? '0' : '') + convertedDate.getHours() ) +
          ':' +
          ((convertedDate.getMinutes() < 10 ? '0' : '') + convertedDate.getMinutes() ) +
          ' ' +
          (convertedDate.getMonth() + 1) +
          '/' +
          convertedDate.getDate();
      };
    }
  ]);
