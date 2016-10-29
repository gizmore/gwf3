'use strict';
var TGC = angular.module('tgc');
TGC.controller('MapCtrl', function($scope, NgMap) {

	$scope.googleMapsUrl="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrEK28--B1PaUlvpHXB-4MzQlUjNPBez0";

	$scope.data = {
	};
	
	$scope.reset = function() {
	};

	NgMap.getMap().then(function(map) {
		    console.log(map.getCenter());
		    console.log('markers', map.markers);
		    console.log('shapes', map.shapes);
		  });
	
});

