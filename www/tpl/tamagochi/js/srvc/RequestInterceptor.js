var TGC = angular.module('tgc');

TGC.factory('RequestInterceptor', [function() {  
    return {
        request: function(config) {
//            if (!SessionService.isAnonymus) {
//                config.headers['x-session-token'] = SessionService.token;
//            }
            return config;
        }
    };
}]);

TGC.config(function($httpProvider) {  
    $httpProvider.interceptors.push('RequestInterceptor');
});
