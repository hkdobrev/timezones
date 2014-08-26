'use strict';

angular.module('timezones')
  .config(['$authProvider', function($authProvider) {
    $authProvider.tokenName = 'access_token';
    $authProvider.signupRedirect = '/';
  }]);

angular.module('timezones.controller', []);

