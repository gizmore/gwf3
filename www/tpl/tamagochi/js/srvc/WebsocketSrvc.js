'use strict';
var TGC = angular.module('tgc');
TGC.service('WebsocketSrvc', function($rootScope, $q) {
	
	var WebsocketSrvc = this;
	
	WebsocketSrvc.SOCKET = null;
	
	WebsocketSrvc.connect = function() {
		return $q(function(resolve, reject){
			console.log('WebsocketSrvc.connect()', window.TGCConfig);
			if (WebsocketSrvc.SOCKET == null) {
				var ws = WebsocketSrvc.SOCKET = new WebSocket(window.TGCConfig.ws_url);
				ws.onopen = function() {
			    	console.log("here");
			    	resolve();
			    	$rootScope.$broadcast('tgc-ws-open');
				};
			    ws.onclose = function() {
			    	WebsocketSrvc.SOCKET = null;
			    	$rootScope.$broadcast('tgc-ws-close');
			    };
			    ws.onerror = function(error) {
			    	console.log(error);
					reject();
			    };
			    ws.onmessage = function(message) {
			    	$rootScope.$broadcast('tgc-ws-message', message);
			    };
			}
			else {
				reject();
			}
		});
	};

	WebsocketSrvc.disconnect = function() {
		console.log('WebsocketSrvc.disconnect()');
		if (WebsocketSrvc.SOCKET != null) {
			WebsocketSrvc.SOCKET.close();
			WebsocketSrvc.SOCKET = null;
		}
	};
	
	
	
	WebsocketSrvc.send = function(messageText) {
		console.log('WebsocketSrvc.send()', messageText);
		if (WebsocketSrvc.SOCKET != null) {
			WebsocketSrvc.SOCKET.send(messageText);
		}
	};

});
