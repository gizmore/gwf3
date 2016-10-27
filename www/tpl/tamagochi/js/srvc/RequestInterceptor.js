var TGC = angular.module('tgc');

TGC.factory('RequestInterceptor', function(ErrorSrvc, $q) {
	return {
		'request': function(config) {
			  return config;
		},
		'requestError': function(rejection) {
			ErrorSrvc.showNetworkError(rejection);
			return $q.reject(rejection);
		},
		'response': function(response) {
			return response;
		},
		'responseError': function(rejection) {
			var code = rejection.status;
			if ((code == 403) || (code == 405)) {
			}
			else {
				ErrorSrvc.showServerError(rejection);
			}
			return $q.reject(rejection);
		}
	};
});

TGC.config(function($httpProvider) {  
	$httpProvider.interceptors.push('RequestInterceptor');
});
