'use strict';
var TGC = angular.module('tgc');
TGC.service('MapUtil', function(ColorUtil, PlayerDlg, PlayerSrvc, ShapeUtil) {
	
	var MapUtil = this;
	
	MapUtil.MAP = null;
	MapUtil.MAP_ID = 'TGCMAP';
	MapUtil.MARKERS = {};
	MapUtil.PAN_TIMER = null;
	MapUtil.PAN_TIMEOUT = 1337;

	MapUtil.OPTIONS = {
//			backgroundColor: '#0008',
			center:  new google.maps.LatLng({lat: 52, lng: 10.4}),
//			clickableIcons: true,
//			disableDefaultUI: false,
//			disableDoubleClickZoom: true,
//			draggable: true,
//			draggableCursor: '/tpl/default/map_draggable_cursor.png',
//			draggingCursor: '/tpl/default/map_dragging_cursor.png',
//			fullscreenControl: false,
//			fullscreenControlOptions: FullscreenControlOptions The display options for the Fullscreen control.
//			heading: 4, // The heading for aerial imagery in degrees measured clockwise from cardinal direction North. Headings are snapped to the nearest available angle for which imagery is available.
//			keyboardShortcuts: false,
//			mapTypeControl: false, // The initial enabled/disabled state of the Map type control.
//			mapTypeControlOptions: // Type:  MapTypeControlOptions – The initial display options for the Map type control.
//			mapTypeId: 'ROADMAP' // Type:  MapTypeId
			maxZoom: 16,
			minZoom: 9,
//			noClear: true,
//			panControl: true,
//			panControlOptions: // Type:  PanControlOptions The display options for the Pan control.
//			rotateControl: true,
//			rotateControlOptions:  // Type:  RotateControlOptions			The display options for the Rotate control.
//			scaleControl: true,
//			scaleControlOptions: // ScaleControlOptions. The initial display options for the Scale control.
//			scrollwheel: true,
//			signInControl: false,
//			streetView: // Type:  StreetViewPanorama A StreetViewPanorama to display when the Street View pegman is dropped on the map. If no panorama is specified, a default StreetViewPanorama will be displayed in the map's div when the pegman is dropped.
//			streetViewControl: false,
//			streetViewControlOptions:  // Type:  StreetViewControlOptions The initial display options for the Street View Pegman control.
//			styles: // Type:  Array<MapTypeStyle> Styles to apply to each of the default map types. Note that for satellite/hybrid and terrain modes, these styles will only apply to labels and geometry.
//			tilt: 0, // Controls the automatic switching behavior for the angle of incidence of the map. The only allowed values are 0 and 45. The value 0 causes the map to always use a 0° overhead view regardless of the zoom level and viewport. The value 45 causes the tilt angle to automatically switch to 45 whenever 45° imagery is available for the current zoom level and viewport, and switch back to 0 whenever 45° imagery is not available (this is the default behavior). 45° imagery is only available for satellite and hybrid map types, within some locations, and at some zoom levels. Note: getTilt returns the current tilt angle, not the value specified by this option. Because getTilt and this option refer to different things, do not bind() the tilt property; doing so may yield unpredictable effects.
			zoom: 9, // The initial Map zoom level. Required. Valid values: Integers between zero, and up to the supported maximum zoom level.
//			zoomControl: false,	
//			zoomControlOptions: // Type:  ZoomControlOptions – The display options for the Zoom control.			
	};
	
	MapUtil.positionToLatLng = function(position) {
		return new google.maps.LatLng({lat: position.coords.latitude, lng: position.coords.longitude});
	};
	
	MapUtil.canvas = function() {
		return document.getElementById(MapUtil.MAP_ID);
	};
	
	MapUtil.map = function(id) {
		id = id || MapUtil.MAP_ID;
		if (!MapUtil.MAP) {
			MapUtil.MAP = new google.maps.Map(MapUtil.canvas(), MapUtil.OPTIONS);
			if (!MapUtil.MAP) {
				console.error('Can not find map with id: '+id);
				return undefined;
			}
			MapUtil.MAP.addListener('center_changed', MapUtil.panBack);
		}
		return MapUtil.MAP;
	};
	
	MapUtil.panBack = function() {
		if (MapUtil.PAN_TIMER) {
			clearTimeout(MapUtil.PAN_TIMER);
			MapUtil.PAN_TIMER = null;
		}
		if ( (PlayerSrvc.OWN) && (PlayerSrvc.OWN.hasPosition()) && (!PlayerSrvc.OWN.NO_SCROLL_LOCK) ) {
			MapUtil.PAN_TIMER = window.setTimeout(function() {
				MapUtil.MAP.panTo(PlayerSrvc.OWN.latLng());
			}, MapUtil.PAN_TIMEOUT);
		}
	};
	
	MapUtil.playerChat = function(player, message) {
		console.log('MapUtil.playerChat()', player, message);
		if (player.marker) {
			player.marker.setLabel(player.name()+': '+message);
			setTimeout(function(){
				player.marker.setLabel(player.name());
			}, 5000);
		};
	};

	/////////////
	// Markers //
	/////////////
	MapUtil.playerForMarker = function(marker) {
		for (var player in MapUtil.MARKERS) {
			if (MapUtil.MARKERS[player] === marker) {
				return player;
			}
		}
		return undefined;
	};
	
	MapUtil.addMarkerForPlayer = function(player) {
		player.marker = new google.maps.Marker({
			position: player.latLng(),
			map: MapUtil.map(),
			title: player.name(),
			label: player.name(),
			size: MapUtil.sizeForPlayer(player),
//			image: MapUtil.imageForPlayer(player),
		});
		player.marker.addListener('click', function(event) {
			PlayerDlg.open(event, player);
		});
		
		MapUtil.MARKERS[player] = player.marker;

		return player.marker;
	};

	MapUtil.removeMarkerForPlayer = function(player) {
		if (player.marker) {
			player.marker.setMap(null);
			player.marker = undefined;
		}
		if (player.shape) {
			player.shape.setMap(null);
			player.shape = undefined;
		}
		delete MapUtil.MARKERS(player);
	}
	
	MapUtil.addPlayer = function(player) {
		return player;
	};
	
	MapUtil.movePlayer = function(player, latLng) {
		var marker = player.marker ? player.marker : MapUtil.addMarkerForPlayer(player);
		MapUtil.styleMarkerForPlayer(player);
		ShapeUtil.initShape(player, MapUtil.map());
	};
	
	MapUtil.styleMarkerForPlayer = function(player) {
		var marker = player.marker;
		marker.setPosition(player.latLng());
		jQuery(marker).animate({
			color: ColorUtil.colorForPlayer(player),
		}, 5000);
	};

	MapUtil.imageForPlayer = function(player) {
	};

	MapUtil.sizeForPlayer = function(player) {
		return 41.13 + player.fighterLevel() + player.ninjaLevel() + player.priestLevel() + player.wizardLevel(); 
	};

});
