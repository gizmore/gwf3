'use strict';
var TGC = angular.module('tgc');
TGC.service('PlayerSrvc', function() {
	
	var PlayerSrvc = this;
	PlayerSrvc.CACHE = {};
	
	
	PlayerSrvc.cache = function(newcache) {
		PlayerSrvc.CACHE = newcache ? newcache : PlayerSrvc.CACHE;
		return PlayerSrvc.CACHE;
	};

});
