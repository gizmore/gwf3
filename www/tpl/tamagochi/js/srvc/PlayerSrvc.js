'use strict';
var TGC = angular.module('tgc');
TGC.service('PlayerSrvc', function($rootScope, CommandSrvc) {
	
	var PlayerSrvc = this;
	
	///////////
	// Cache //
	///////////
	PlayerSrvc.OWN = null;
	PlayerSrvc.CACHE = {};

	PlayerSrvc.getOrAddPlayer = function(name, player) {
		console.log("PlayerSrvc.getOrAddPlayer()", name);
		return PlayerSrvc.hasPlayer(name) ? PlayerSrvc.getPlayer(name) : PlayerSrvc.addPlayer(player);
	};

	PlayerSrvc.getPlayer = function(name) {
		console.log("PlayerSrvc.getPlayer()", name);
		return PlayerSrvc.CACHE[name];
	};

	PlayerSrvc.hasPlayer = function(name) {
		console.log("PlayerSrvc.hasPlayer()", name);
		return PlayerSrvc.CACHE[name] ? true : false;
	};
	
	PlayerSrvc.addPlayer = function(player) {
		console.log("PlayerSrvc.getPlayer()", player);
		PlayerSrvc.CACHE[player.name()] = player;
		return player;
	};

	PlayerSrvc.removePlayer = function(player) {
		console.log("PlayerSrvc.removePlayer()", player);
		if (PlayerSrvc.OWN === player) {
			PlayerSrvc.OWN = null;
		}
		delete PlayerSrvc.CACHE(player.name());
		return player;
	};
	
	PlayerSrvc.updateCacheForPlayer = function(player, newData) {
		console.log("PlayerSrvc.updateCacheForPlayer()", player);
		if (!player.recache) {
			player.recache = newData.hash != player.hash();
			if (player.recache) {
				player.hash(newData.hash);
			}
		}
	};
	

	//////////
	// Auth //
	//////////
	PlayerSrvc.pingData = function(data) {
		console.log("PlayerSrvc.pingData()", data);
		if (data.authed) {
			if (!PlayerSrvc.OWN) {
				PlayerSrvc.login(data);
			}
		}
	};
	
	PlayerSrvc.login = function(data) {
		console.log("PlayerSrvc.login()", data);
		var player = PlayerSrvc.OWN = new window.TGC.Player(data.player, data.user, data.secret);
		PlayerSrvc.addPlayer(player);
		$rootScope.$broadcast('tgc-own-player-loaded', PlayerSrvc.OWN);
	};
	
	
	PlayerSrvc.logout = function() {
		console.log("PlayerSrvc.logout()");
		PlayerSrvc.removePlayer(PlayerSrvc.OWN);
		$rootScope.$broadcast('tgc-own-player-removed', PlayerSrvc.OWN);
		PlayerSrvc.OWN = null;
	};
	
	//////////
	// Lazy //
	//////////
	PlayerSrvc.withStats = function(player) {
		return CommandSrvc.player(player).then(function(payload){
			console.log(payload);
			player.JSON = JSON.parse(payload).player;
			return player;
		});
	};
	
});
