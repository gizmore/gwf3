'use strict';
var TGC = angular.module('tgc');
TGC.service('ErrorSrvc', function() {
	
	var ErrorSrvc = this;
	
	ErrorSrvc.showNetworkError = function(error) {
		console.log(error);
		console.err(error);
	};

	ErrorSrvc.showServerError = function(error) {
		console.log(error);
		console.err(error);
	};
	

});
