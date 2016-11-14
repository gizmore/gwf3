'use strict';
var TGC = angular.module('tgc');
TGC.service('CommandSrvc', function($rootScope, $injector, ErrorSrvc, WebsocketSrvc) {
	
	var CommandSrvc = this;
	
	CommandSrvc.statsScope = null;
	
	CommandSrvc.getMapUtil = function() {
		if (!CommandSrvc.MAPUTIL) {
			CommandSrvc.MAPUTIL = $injector.get('MapUtil');
		}
		return CommandSrvc.MAPUTIL;
	};
	
	CommandSrvc.getChatSrvc = function() {
		if (!CommandSrvc.CHATSERVICE) {
			CommandSrvc.CHATSERVICE = $injector.get('ChatSrvc');
		}
		return CommandSrvc.CHATSERVICE;
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

	CommandSrvc.player = function(player) {
		return WebsocketSrvc.sendCommand('player', player.name(), false);
	};
	
	CommandSrvc.chat = function($scope, messageText) {
		console.log('CommandSrvc.chat()', messageText);
		return WebsocketSrvc.sendCommand('chat', messageText);
	};
	
	CommandSrvc.fight = function(player) {
		console.log('CommandSrvc.fight()', player);
		return WebsocketSrvc.sendCommand('fight', player.name(), false);
	};

	CommandSrvc.attack = function(player) {
		console.log('CommandSrvc.attack()', player);
		return WebsocketSrvc.sendCommand('attack', player.name(), false);
	};
	
	CommandSrvc.brew = function(player, runes) {
		console.log('CommandSrvc.brew()', player, runes);
		return WebsocketSrvc.sendJSONCommand('brew', { target: player.name(), runes: runes });
	};
	
	CommandSrvc.cast = function(player, runes) {
		console.log('CommandSrvc.cast()', player, runes);
		return WebsocketSrvc.sendJSONCommand('cast', { target: player.name(), runes: runes });
	};
	
	
	
	/////////////////////
	// Server commands //
	/////////////////////
	CommandSrvc.ERR = function($scope, message)
	{
		return ErrorSrvc.showError(message, "User Error");
	}
	
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
		var MapUtil = CommandSrvc.getMapUtil();
		var ChatSrvc = CommandSrvc.getChatSrvc();
		var PlayerSrvc = CommandSrvc.getPlayerSrvc();
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
	
	CommandSrvc.QUIT = function($scope, payload) {
		console.log('CommandSrvc.QUIT()', payload);
		var MapUtil = CommandSrvc.getMapUtil();
		var PlayerSrvc = CommandSrvc.getPlayerSrvc();
		var name = payload;
		var player = PlayerSrvc.getPlayer(name);
		if (player) {
			MapUtil.removeMarkerForPlayer(player);
			PlayerSrvc.removePlayer(player);
		}
		else {
			console.error('Player not found: '+name);
		}
	};
	
	CommandSrvc.CAST = function($scope, payload) {
		var MapUtil = CommandSrvc.getMapUtil();
		var ChatSrvc = CommandSrvc.getChatSrvc();
		var PlayerSrvc = CommandSrvc.getPlayerSrvc();
		var data = JSON.parse(payload);
		console.log(data);
		var OWN = PlayerSrvc.OWN;
//		if (data.failed) {
//		}
		if (data.code) {
			eval(data.code);
		}
		if (data.message) {
			ErrorSrvc.showMessage(data.message, 'Casting');
		}
	};


});
