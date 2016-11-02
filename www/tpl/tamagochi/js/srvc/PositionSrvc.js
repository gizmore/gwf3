'use strict';
/**
 * --unsafely-treat-insecure-origin-as-secure="http://giz.org" 
 */
var TGC = angular.module('tgc');
TGC.service('PositionSrvc', function($rootScope, $q, ErrorSrvc, WebsocketSrvc) {
	
	var PositionSrvc = this;
	
	PositionSrvc.CURRENT_STAMP = new Date().getTime();
	PositionSrvc.FORCE_POSITION_MILLIS = 20000;
	
	PositionSrvc.CURRENT = { coords: { latitude: 52.13, longitude: 10.37 } };
	
	PositionSrvc.HIGH_PRECISION = false;
	
	PositionSrvc.TIMER = null;
	PositionSrvc.INTERVAL = null;
	PositionSrvc.INTERVAL_MILLIS = 5000;

	PositionSrvc.OPTIONS = {
			enableHighAccuracy: PositionSrvc.HIGH_PRECISION,
			maximumAge: 60000,
			timeout: 57000
	};
	
	PositionSrvc.setLatLng = function(lat, lng) {
		console.log('PositionSrvc.setLatLng()', lat, lng);
		PositionSrvc.CURRENT = { coords: { latitude: lat, longitude: lng } };
	};
	
	PositionSrvc.start = function() {
		console.log('PositionSrvc.start()');
		if (PositionSrvc.TIMER === null) {
			PositionSrvc.TIMER = navigator.geolocation.watchPosition(PositionSrvc.geoSuccess, PositionSrvc.geoFailure, PositionSrvc.OPTIONS);	
		}
		if (PositionSrvc.INTERVAL === null) {
			PositionSrvc.INTERVAL = setInterval(PositionSrvc.intervalCalled, PositionSrvc.INTERVAL_MILLIS);
		}
	};
	
	PositionSrvc.intervalCalled = function() {
		console.log('PositionSrvc.intervalCalled()');
		var now = new Date().getTime();
		var age = now - PositionSrvc.CURRENT_STAMP;
		if (age >= PositionSrvc.FORCE_POSITION_MILLIS) {
			PositionSrvc.geoSuccess(PositionSrvc.CURRENT);
		}
	};
	
	PositionSrvc.stop = function() {
		console.log('PositionSrvc.stop()');
		if (PositionSrvc.INTERVAL !== null) {
			clearInterval(PositionSrvc.INTERVAL);
			PositionSrvc.INTERVAL = null;
		}
	};
	
	PositionSrvc.geoSuccess = function(position) {
		console.log('PositionSrvc.geoSuccess()', position);
		PositionSrvc.CURRENT = position;
		PositionSrvc.CURRENT_STAMP = new Date().getTime();
		$rootScope.$broadcast('tgc-position-changed', PositionSrvc.CURRENT);
	};
	
	PositionSrvc.geoFailure = function(error) {
		console.log('PositionSrvc.geoFailure()', error);
		
	};
	
	PositionSrvc.latitude = function() {
		return PositionService.CURRENT.coords.latitude;
	};
	
	PositionSrvc.longitude = function() {
		return PositionService.CURRENT.coords.longitude;
	};
	
	
	///////////////////////////////////
	PositionSrvc.bootstrap = function() {
		console.log('PositionSrvc.bootstrap()');
		if (!("geolocation" in navigator)) {
			ErrorSrvc.showError('Geolocation not available', 'Missing Requirement');
			return;
		}
		return $q(function(resolve, reject) {
			
			var options = {
				enableHighAccuracy: true,
				maximumAge: 0,
				timeout: 19000
			};
			
			navigator.geolocation.getCurrentPosition(function(position){
				PositionSrvc.geoSuccess(position);
				resolve();
			}, function(error){
				console.log("REJ");
				reject();
			}, options);
			
		});
	};
	
});
