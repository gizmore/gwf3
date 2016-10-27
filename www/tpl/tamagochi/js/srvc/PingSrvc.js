'use strict';
var TGC = angular.module('tgc');
TGC.service('PingSrvc', function($state, RequestSrvc, PlayerSrvc) {
	var PingSrvc = this;
	PingSrvc.ping = function() {
		console.log('PingSrvc.ping()');
		return RequestSrvc.send('tgc/ping').then(function(data) {
			PlayerSrvc.pingData(data.data);
			$state.go('game');
		}, function(response) {
			var code = response.status;
			if ((code == 403) || (code == 405)) {
				$state.go('login');
			}
		});
	};
});
