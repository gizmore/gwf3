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
				PingSrvc.RUNNING = false;
				PlayerSrvc.pingData(data.data);
//				if ($state.name !== 'game') {
					$state.go('connect');
//				}
			}, function(response) {
				PingSrvc.RUNNING = false;
				var code = response.status;
				if ((code == 403) || (code == 405)) {
					$state.go('login');
				}
			});
		}
	};

});
