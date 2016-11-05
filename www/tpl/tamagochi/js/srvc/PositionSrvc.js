'use strict';
var TGC = angular.module('tgc');
TGC.service('PositionSrvc', function($rootScope, $q, ErrorSrvc) {
	
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
	
	PositionSrvc.latitude = function() {
		return PositionService.CURRENT.coords.latitude;
	};
	
	PositionSrvc.longitude = function() {
		return PositionService.CURRENT.coords.longitude;
	};
	
	PositionSrvc.setLatLng = function(lat, lng) {
		console.log('PositionSrvc.setLatLng()', lat, lng);
		PositionSrvc.geoSuccess(PositionSrvc.getPosition(lat, lng));
	};

	PositionSrvc.getLatLng = function(lat, lng) {
		return new google.maps.LatLng({lat: lat, lng: lng});
	};

	PositionSrvc.getPosition = function(lat, lng) {
		return { coords: { latitude: lat, longitude: lng } };
	};
	
	PositionSrvc.start = function() {
		console.log('PositionSrvc.start()');
		if (PositionSrvc.TIMER === null) {
			PositionSrvc.TIMER = navigator.geolocation.watchPosition(PositionSrvc.watchSuccess, PositionSrvc.geoFailure, PositionSrvc.OPTIONS);	
		}
		if (PositionSrvc.INTERVAL === null) {
			PositionSrvc.INTERVAL = setInterval(PositionSrvc.intervalCalled, PositionSrvc.INTERVAL_MILLIS);
		}
	};
	
	PositionSrvc.intervalCalled = function() {
//		console.log('PositionSrvc.intervalCalled()');
		var now = new Date().getTime();
		var age = now - PositionSrvc.CURRENT_STAMP;
		if (age >= PositionSrvc.FORCE_POSITION_MILLIS) {
			PositionSrvc.geoSuccess(PositionSrvc.CURRENT);
			PositionSrvc.broadcast();
		}
	};
	
	PositionSrvc.stop = function() {
		console.log('PositionSrvc.stop()');
		if (PositionSrvc.INTERVAL !== null) {
			clearInterval(PositionSrvc.INTERVAL);
			PositionSrvc.INTERVAL = null;
		}
	};
	
	PositionSrvc.watchSuccess = function(position) {
		console.log('PositionSrvc.watchSuccess()', position);
		PositionSrvc.geoSuccess(position);
		PositionSrvc.broadcast();
	};

	PositionSrvc.broadcast = function() {
		$rootScope.$broadcast('tgc-position-changed', PositionSrvc.CURRENT);
	};
	

	PositionSrvc.geoSuccess = function(position) {
		PositionSrvc.CURRENT = position;
		PositionSrvc.CURRENT_STAMP = new Date().getTime();
	};
	
	PositionSrvc.geoFailure = function(error) {
		console.log('PositionSrvc.geoFailure()', error);
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
				PositionSrvc.broadcast();
				PositionSrvc.start();
				resolve();
			}, function(error){
				reject();
			}, options);
			
		});
	};
	
});
