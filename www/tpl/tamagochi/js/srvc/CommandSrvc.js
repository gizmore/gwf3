'use strict';
var TGC = angular.module('tgc');
TGC.service('CommandSrvc', function($rootScope, MapUtil, PlayerSrvc, WebsocketSrvc) {
	
	var CommandSrvc = this;
	
	/////////////////////
	// Client commands //
	/////////////////////
	
	CommandSrvc.pos = function($scope, position) {
		console.log('CommandSrvc.pos()', position);
		WebsocketSrvc.sendJSONCommand('pos', { lat:position.coords.latitude, lng: position.coords.longitude });
	};
	
	CommandSrvc.slap = function($scope, name) {
		
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
		var player = new window.TGC.Player(data.player, data.user, null);
		PlayerSrvc.addPlayer(player);
		return player;
	};

});
