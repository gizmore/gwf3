'use strict';
var TGC = angular.module('tgc');
TGC.service('PlayerSrvc', function() {
	
	var PlayerSrvc = this;
	PlayerSrvc.OWN = null;
	PlayerSrvc.CACHE = null;

	PlayerSrvc.cache = function(newcache) {
		PlayerSrvc.CACHE = newcache ? newcache : PlayerSrvc.CACHE;
		return PlayerSrvc.CACHE;
	};

	PlayerSrvc.pingData = function(data) {
		PlayerSrvc.OWN = data;
	};
	
});
