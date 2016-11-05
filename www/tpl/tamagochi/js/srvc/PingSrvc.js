'use strict';
var TGC = angular.module('tgc');
TGC.service('PingSrvc', function($state, RequestSrvc, PlayerSrvc, ConstSrvc) {

	var PingSrvc = this;
	
	PingSrvc.RUNNING = false;
	
	PingSrvc.ping = function() {
		console.log('PingSrvc.ping()');
		if (!PingSrvc.RUNNING) {
			PingSrvc.RUNNING = true;
			ConstSrvc.inLogin(true);
			return RequestSrvc.send('tgc/ping').then(function(data) {
				PlayerSrvc.pingData(data.data);
				$state.go('connect');
				PingSrvc.RUNNING = false;
			}, function(response) {
				var code = response.status;
				if ((code == 403) || (code == 405)) {
					$state.go('login');
				}
				PingSrvc.RUNNING = false;
			});
		}
	};

});
