'use strict';
var TGC = angular.module('tgc');
TGC.service('RequestSrvc', function($http) {
	
	var RequestSrvc = this;
	
	RequestSrvc.send = function(method, data) {
		return $http({
			method: 'POST',
			url: '/tgc/'+method,
			data: data,
			withCredentials: true,
		});
	};
	
	RequestSrvc.ping = function() {
		console.log('RequestSrvc.ping()');
		return RequestSrvc.send('ping')
	};
	
});
