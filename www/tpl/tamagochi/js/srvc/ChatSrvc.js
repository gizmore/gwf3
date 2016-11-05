'use strict';
var TGC = angular.module('tgc');
TGC.service('ChatSrvc', function() {
	
	var ChatSrvc = this;
	
	ChatSrvc.HISTORY = [];
	
	ChatSrvc.playerChat = function(player, message) {
		console.log('ChatSrvc.playerChat()', player, message);
	};

});
