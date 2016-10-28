'use strict';
var TGC = angular.module('tgc');
TGC.service('AvatarSrvc', function(RequestSrvc) {
	
	var AvatarSrvc = this;

	AvatarSrvc.CACHE = {};
	
	AvatarSrvc.cache = function(cache) {
		if (cache) { AvatarSrvc.CACHE = cache; }
		return AvatarSrvc.CACHE; 
	};
	
	AvatarSrvc.initCache = function(player) {
		return AvatarSrvc.requestCache(player).then(AvatarSrvc.requestCacheSuccess, AvatarSrvc.requestCacheFailure);
	};
	
	AvatarSrvc.requestCache = function(player) {
		console.log('AvatarSrvc.requestCache()', player);
		return RequestSrvc.send('tgc/avtar_cache?player='+player.id());
	};
	
	AvatarSrvc.requestCacheSuccess = function(data) {
		console.log('AvatarSrvc.requestCacheSuccess()', data);
	};
	
	AvatarSrvc.requestCacheFailure = function(data) {
		console.log('AvatarSrvc.requestCacheFailure()', data);
	};
	
	AvatarSrvc.hasAvatar = function(player) {
	};

	AvatarSrvc.canCreateAvatar = function(player) {
	};
});
