'use strict';
var TGC = angular.module('tgc');
TGC.service('PlayerSrvc', function($rootScope) {
	
	var PlayerSrvc = this;
	
	///////////
	// Cache //
	///////////
	PlayerSrvc.OWN = null;
	PlayerSrvc.CACHE = {};

	PlayerSrvc.getOrAddPlayer = function(name, player) {
		console.log("PlayerSrc.getOrAddPlayer()", name);
		return PlayerSrvc.hasPlayer(name) ? PlayerSrvc.getPlayer(name) : PlayerSrvc.addPlayer(player);
	};

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
		PlayerSrvc.CACHE[player.name()] = player;
		return player;
	};

	PlayerSrvc.removePlayer = function(player) {
		console.log("PlayerSrc.removePlayer()", player);
		delete PlayerSrvc.CACHE(player.name());
		return player;
	};
	
	PlayerSrvc.updateCacheForPlayer = function(player, newData) {
		player.recache = newData.hash != player.hash();
	};
	

	//////////
	// Auth //
	//////////
	PlayerSrvc.pingData = function(data) {
		console.log("PlayerSrc.pingData()", data);
		if (data.authed) {
			if (!PlayerSrvc.OWN) {
				PlayerSrvc.login(data);
			}
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
	
	PlayerSrvc.requestStats = function(player) {
		
		
		
		return CommandSrvc.player(player).then(function(){
			
		});
	};
	
});
