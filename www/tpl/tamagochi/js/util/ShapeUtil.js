'use strict';
var TGC = angular.module('tgc');
TGC.service('ShapeUtil', function(ConstSrvc, ColorUtil) {
	
	var ShapeUtil = this;
	
	ShapeUtil.addPlayer = function(player, map) {
		if (!player.shape) {
			ShapeUtil.initShape(player, map);
		}
	};
	
	ShapeUtil.initShape = function(player, map) {
		console.log('ShapeUtil.initShape()', player.name());
		
		if ((!player.hasStats()) || (!player.hasPosition())) {
			return;
		}

		if (player.shape) {
			player.shape.setMap(null);
			player.shape = undefined;
		}
		
		var lat = player.lat(), lng = player.lng();

		var latMin = ConstSrvc.SKILL_SHAPE_RADIUS_LAT_MIN;
		var latMax = ConstSrvc.SKILL_SHAPE_RADIUS_LAT_MAX;
		var latRange = latMax - latMin;

		var lngMin = ConstSrvc.SKILL_SHAPE_RADIUS_LNG_MIN;
		var lngMax = ConstSrvc.SKILL_SHAPE_RADIUS_LNG_MAX;
		var lngRange = lngMax - lngMin;
		
		var latPerLevel = latRange / ConstSrvc.MAX_LEVEL;
		var lngPerLevel = lngRange / ConstSrvc.MAX_LEVEL;

		var f = player.fighterLevel();
		var n = player.ninjaLevel();
		var p = player.priestLevel();
		var w = player.wizardLevel();
		
		var path = [
			{lat: lat + f * latPerLevel, lng: lng},
			{lat: lat, lng: lng + n * lngPerLevel},
			{lat: lat - p * latPerLevel, lng: lng},
			{lat: lat, lng: lng - w * lngPerLevel}];
			
		player.shape = new google.maps.Polyline({
			path: path,
			geodesic: true,
			strokeColor: ColorUtil.colorForPlayer(player),
			strokeOpacity: ColorUtil.opacityForPlayer(player),
			strokeWeight: 4
		});
		
		player.shape.setMap(map);
	};

});
