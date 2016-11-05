'use strict';
var TGC = angular.module('tgc');
TGC.service('WebsocketSrvc', function($rootScope, $q, PlayerSrvc) {
	
	var WebsocketSrvc = this;
	
	WebsocketSrvc.SOCKET = null;
	
	WebsocketSrvc.QUEUE = [];
	WebsocketSrvc.QUEUE_INTERVAL = null;
	WebsocketSrvc.QUEUE_SEND_MILLIS = 250;
	
	WebsocketSrvc.connect = function() {
		return $q(function(resolve, reject){
			console.log('WebsocketSrvc.connect()', window.TGCConfig);
			if (WebsocketSrvc.SOCKET == null) {
				var ws = WebsocketSrvc.SOCKET = new WebSocket(window.TGCConfig.ws_url);
				ws.onopen = function() {
					WebsocketSrvc.startQueue();
			    	resolve();
			    	$rootScope.$broadcast('tgc-ws-open');
				};
			    ws.onclose = function() {
			    	WebsocketSrvc.disconnect();
			    	$rootScope.$broadcast('tgc-ws-close');
			    };
			    ws.onerror = function(error) {
			    	WebsocketSrvc.disconnect();
					reject(error);
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
	
	WebsocketSrvc.startQueue = function() {
		console.log('WebsocketSrvc.startQueue()');
		if (WebsocketSrvc.QUEUE_INTERVAL === null) {
			WebsocketSrvc.QUEUE_INTERVAL = setInterval(WebsocketSrvc.flushQueue, WebsocketSrvc.QUEUE_SEND_MILLIS);
		}
	};
	
	WebsocketSrvc.flushQueue = function() {
		if (!WebsocketSrvc.connected()) {
			// TODO: Recon?
		}
		else {
			WebsocketSrvc.sendQueue();
		}
	};
	
	WebsocketSrvc.sendQueue = function() {
		if (WebsocketSrvc.QUEUE.length > 0) {
//			console.log('WebsocketSrvc.sendQueue()');
		}
	};
	

	WebsocketSrvc.disconnect = function() {
		console.log('WebsocketSrvc.disconnect()');
		if (WebsocketSrvc.SOCKET != null) {
			WebsocketSrvc.SOCKET.close();
			WebsocketSrvc.SOCKET = null;
		}
	};
	
	WebsocketSrvc.connected = function() {
		return WebsocketSrvc.SOCKET ? true : false;
	};

	WebsocketSrvc.sendJSONCommand = function(command, object) {
//		console.log('WebsocketSrvc.sendJSONCommand()', command, object);
		return WebsocketSrvc.sendCommand(command, JSON.stringify(object));
	};
	
	WebsocketSrvc.sendCommand = function(command, payload) {
//		console.log('WebsocketSrvc.sendCommand()', command, payload);
		return $q(function(resolve, reject) {
			if (PlayerSrvc.OWN) {
				var messageText = PlayerSrvc.OWN.secret()+":"+command+":"+payload;
				if (WebsocketSrvc.connected()) {
					WebsocketSrvc.send(messageText);
					resolve();
				} else {
					WebsocketSrvc.QUEUE.push(messageText);
					reject();
				}
			}
			else {
				reject();
			}
			
		});
	};
	
	WebsocketSrvc.send = function(messageText) {
		console.log('WebsocketSrvc.send()', messageText);
		WebsocketSrvc.SOCKET.send(messageText);
	};

});
