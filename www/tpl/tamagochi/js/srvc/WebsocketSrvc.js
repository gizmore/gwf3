'use strict';
var TGC = angular.module('tgc');
TGC.service('WebsocketSrvc', function($rootScope, $q, $injector, ConstSrvc, ErrorSrvc) {
	
	var WebsocketSrvc = this;
	
	WebsocketSrvc.getPlayerSrvc = function() {
		if (!WebsocketSrvc.PLAYERSERVICE) {
			WebsocketSrvc.PLAYERSERVICE = $injector.get('PlayerSrvc');
		}
		return WebsocketSrvc.PLAYERSERVICE;
	};
	
	WebsocketSrvc.NEXT_MID = 1000000;
	WebsocketSrvc.SYNC_MSGS = {};
	
	WebsocketSrvc.SOCKET = null;
	
	WebsocketSrvc.QUEUE = [];
	WebsocketSrvc.QUEUE_INTERVAL = null;
	WebsocketSrvc.QUEUE_SEND_MILLIS = 250;
	
	WebsocketSrvc.connect = function() {
		return $q(function(resolve, reject){
			console.log('WebsocketSrvc.connect()', window.TGCConfig);
			if (WebsocketSrvc.SOCKET == null) {
				var ws = WebsocketSrvc.SOCKET = new WebSocket(ConstSrvc.websocketURL());
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
			    	if (message.data.indexOf('ERR') === 0) {
			    		ErrorSrvc.showError(message.data, 'User Error');
			    	}
			    	else if (message.data.indexOf(':MID:') >= 0) {
			    		if (!WebsocketSrvc.syncMessage(message.data)) {
			    			$rootScope.$broadcast('tgc-ws-message', message);
			    		}
			    	} else {
		    			$rootScope.$broadcast('tgc-ws-message', message);
			    	}
			    };
			}
			else {
				reject();
			}
		});
	};

	WebsocketSrvc.nextMid = function() {
		return sprintf('%7d', WebsocketSrvc.NEXT_MID++);
	};

	WebsocketSrvc.syncMessage = function(messageText) {
		var parts = explode(':', messageText, 4);
		var cmd = parts[0];
		if (parts[1] !== 'MID') {
			return false;
		}
		var mid = parts[2];
		var payload = parts[3];
		
		if (WebsocketSrvc.SYNC_MSGS[mid]) {
			WebsocketSrvc.SYNC_MSGS[mid].resolve(payload);
		}
		
		return true;
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
			WebsocketSrvc.NEXT_MID = 1000000;
			WebsocketSrvc.SYNC_MSGS = {};
		}
	};
	
	WebsocketSrvc.connected = function() {
		return WebsocketSrvc.SOCKET ? true : false;
	};

	WebsocketSrvc.sendJSONCommand = function(command, object, async=true) {
//		console.log('WebsocketSrvc.sendJSONCommand()', command, object);
		return WebsocketSrvc.sendCommand(command, JSON.stringify(object), async);
	};
	
	WebsocketSrvc.sendCommand = function(command, payload, async=true) {
		
		var PlayerSrvc = WebsocketSrvc.getPlayerSrvc();
//		console.log('WebsocketSrvc.sendCommand()', command, payload);
		var d = $q.defer();
		if (!PlayerSrvc.OWN) {
			d.reject();
		}
		else if (!WebsocketSrvc.connected()) {
//			WebsocketSrvc.QUEUE.push(messageText);
			d.reject();
		}
		else {

			if (!async) {
				var mid = WebsocketSrvc.NEXT_MID++;
				WebsocketSrvc.SYNC_MSGS[mid] = d;
				payload = sprintf('MID:%s:%s', mid, payload);
			}
			
			var messageText = PlayerSrvc.OWN.secret()+":"+command+":"+payload;
			
//			if (!async) {
//				var mid = WebsocketSrvc.NEXT_MID++;
//				WebsocketSrvc.SYNC_MSGS[mid].push(d);
//				messageText = sprintf('MID:%s:%s', mid, messageText);
//			}

			WebsocketSrvc.send(messageText);
			
			if (async) {
				d.resolve();
			}
		}
		
		return d.promise;
	};
	
	WebsocketSrvc.send = function(messageText) {
		console.log('WebsocketSrvc.send()', messageText);
		WebsocketSrvc.SOCKET.send(messageText);
	};

});
