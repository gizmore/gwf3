'use strict';
/**
 * --unsafely-treat-insecure-origin-as-secure="http://giz.org" 
 */
var TGC = angular.module('tgc');
TGC.service('PositionSrvc', function($rootScope, $q, ErrorSrvc) {
	
	var PositionSrvc = this;
	
	PositionSrvc.CURRENT = null;
	
	PositionSrvc.HIGH_PRECISION = false;
	
	PositionSrvc.TIMER = null;
	PositionSrvc.OPTIONS = {
			enableHighAccuracy: PositionSrvc.HIGH_PRECISION,
			maximumAge: 60000,
			timeout: 57000
	};
	
	PositionSrvc.start = function() {
		console.log('PositionSrvc.start()');
		if (PositionSrvc.TIMER !== null) {
			PositionSrvc.TIMER = navigator.geolocation.watchPosition(PositionSrvc.geoSuccess, PositionSrvc.geoFailure, PositionSrvc.OPTIONS);	
		}
	};
	
	PositionSrvc.stop = function() {
		console.log('PositionSrvc.stop()');
	};
	
	PositionSrvc.geoSuccess = function(position) {
		console.log('PositionSrvc.geoSuccess()', position);
		$rootScope.$broadcast('tgc-position-changed', position);
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
				resolve();
			}, function(error){
				console.log("REJ");
				reject();
			}, options);
			
		});
	};
	
});
