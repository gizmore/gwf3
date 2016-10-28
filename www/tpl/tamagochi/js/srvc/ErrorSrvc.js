'use strict';
var TGC = angular.module('tgc');
TGC.service('ErrorSrvc', function() {
	
	var ErrorSrvc = this;
	
	ErrorSrvc.showError = function(text, title) {
		console.log(text);
		console.err(text);
	};
	
	ErrorSrvc.showNetworkError = function(error) {
		ErrorSrvc.showError(error, 'Netz doof');
	};

	ErrorSrvc.showServerError = function(error) {
		ErrorSrvc.showError(error, 'Server dppf')
	};
	

});
