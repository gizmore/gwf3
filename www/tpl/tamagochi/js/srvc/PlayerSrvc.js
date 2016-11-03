'use strict';
var TGC = angular.module('tgc');
TGC.service('PlayerSrvc', function($rootScope) {
	
	var PlayerSrvc = this;
	
	///////////
	// Cache //
	///////////
	PlayerSrvc.OWN = null;
	PlayerSrvc.CACHE = {};

	PlayerSrvc.getPlayer = function(name) {
		console.log("PlayerSrc.getPlayer()", name);
		return PlayerSrvc.CACHE[name];
	};

	PlayerSrvc.hasPlayer = function(name) {
		console.log("PlayerSrc.hasPlayer()", name);
		return PlayerSrvc.CACHE[name] ? true : false;
	};
	
	PlayerSrvc.addPlayer = function(player) {
		console.log("PlayerSrc.getPlayer()", player);
		PlayerSrvc.CACHE[name] = player;
		return PlayerSrvc;
	};

	PlayerSrvc.removePlayer = function(player) {
		console.log("PlayerSrc.removePlayer()", player);
		delete PlayerSrvc.CACHE(name);
	};

	//////////
	// Auth //
	//////////
	PlayerSrvc.pingData = function(data) {
		console.log("PlayerSrc.pingData()", data);
		if (data.authed) {
			PlayerSrvc.login(data);
		}
	};
	
	PlayerSrvc.login = function(data) {
		console.log("PlayerSrc.login()", data);
		var player = PlayerSrvc.OWN = new window.TGC.Player(data.player, data.user, data.secret);
		PlayerSrvc.addPlayer(player);
		$rootScope.$broadcast('tgc-own-player-loaded', PlayerSrvc.OWN);
	};
	
	
	PlayerSrvc.logout = function() {
		console.log("PlayerSrc.logout()");
		PlayerSrvc.removePlayer(PlayerSrvc.OWN);
		$rootScope.$broadcast('tgc-own-player-removed', PlayerSrvc.OWN);
		PlayerSrvc.OWN = null;
	};
	
});
