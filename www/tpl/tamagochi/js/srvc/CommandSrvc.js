'use strict';
var TGC = angular.module('tgc');
TGC.service('CommandSrvc', function($rootScope, $injector, WebsocketSrvc) {
	
	var CommandSrvc = this;
	
	CommandSrvc.statsScope = null;
	
	CommandSrvc.getMapUtil = function() {
		if (!CommandSrvc.MAPUTIL) {
			CommandSrvc.MAPUTIL = $injector.get('MapUtil');
		}
		return CommandSrvc.MAPUTIL;
	};
	
	CommandSrvc.getPlayerSrvc = function() {
		if (!CommandSrvc.PLAYERSERVICE) {
			CommandSrvc.PLAYERSERVICE = $injector.get('PlayerSrvc');
		}
		return CommandSrvc.PLAYERSERVICE;
	};
	
	/////////////////////
	// Client commands //
	/////////////////////
	CommandSrvc.ping = function($scope, version) {
		return WebsocketSrvc.sendCommand('ping', version);
	};
	
	CommandSrvc.pos = function($scope, position) {
		console.log('CommandSrvc.pos()', position);
		return WebsocketSrvc.sendJSONCommand('pos', { lat:position.coords.latitude, lng: position.coords.longitude });
	};

	CommandSrvc.stats = function($scope) {
		CommandSrvc.statsScope = $scope;
		return WebsocketSrvc.sendCommand('stats');
	};

	CommandSrvc.chat = function($scope, messageText) {
		console.log('CommandSrvc.chat()', messageText);
		return WebsocketSrvc.sendCommand('chat', messageText);
	};
	
	CommandSrvc.slap = function($scope, name) {
		console.log('CommandSrvc.slap()', name);
		return WebsocketSrvc.sendCommand('slap', name);
	};
	
	CommandSrvc.player = function(player) {
		return WebsocketSrvc.sendCommand('player', player.name(), false);
	};

	/////////////////////
	// Server commands //
	/////////////////////
	
	CommandSrvc.PONG = function($scope, payload) {
		console.log('CommandSrvc.PONG()', payload);
		$scope.data.version = payload;
	};
	
	CommandSrvc.POS = function($scope, payload) {
		console.log('CommandSrvc.POS()', payload);
		var data = JSON.parse(payload);
		var name = data.player.name;
		var player = null;
		
		var MapUtil = CommandSrvc.getMapUtil();
		var PlayerSrvc = CommandSrvc.getPlayerSrvc();

		if (PlayerSrvc.hasPlayer(name)) {
			player = PlayerSrvc.getPlayer(name);
		}
		else {
			player = new window.TGC.Player(data.player, null, null);
			PlayerSrvc.addPlayer(player);
			MapUtil.addPlayer(player);
		}
		player.moveTo(data.pos.lat, data.pos.lng)
		MapUtil.movePlayer(player);
		PlayerSrvc.updateCacheForPlayer(player, data);
		return player;
	};
	
	CommandSrvc.CHAT = function($scope, payload) {
		console.log('CommandSrvc.CHAT()', payload);
		var name = payload.substrUntil(':');
		var text = payload.substrFrom(':');
		var player = PlayerSrvc.getPlayer(name);
		if (player) {
			MapUtil.playerChat(player, text);
			ChatSrvc.playerChat(player, text);
		}
		else {
			console.error('Player not found: '+name);
		}
	};

	CommandSrvc.STATS = function($scope, payload) {
		console.log('CommandSrvc.STATS()', payload);
		CommandSrvc.statsScope.data.stats = JSON.parse(payload);
	};

});
