var TGC = angular.module('tgc');

TGC.factory('RequestInterceptor', [function() {  
	return {
		'request': function(config) {
			  return config;
		},
		'requestError': function(rejection) {
			if (canRecover(rejection)) {
				return responseOrNewPromise
			}
			return $q.reject(rejection);
		},
		'response': function(response) {
			return response;
		},
		'responseError': function(rejection) {
			if (canRecover(rejection)) {
				return responseOrNewPromise
			}
			return $q.reject(rejection);
		}
	};
}]);

TGC.config(function($httpProvider) {  
	$httpProvider.interceptors.push('RequestInterceptor');
});
