'use strict';
var TGC = angular.module('tgc');
TGC.service('PingSrvc', function(RequestSrvc) {
	
	var PingSrvc = this;
	
	PingSrvc.ping = function() {
		return RequestSrvc.send('tgc/ping').then(function(data) {
			console.log(data);
		});
	};

});
