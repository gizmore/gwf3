'use strict';
var TGC = angular.module('tgc');
TGC.service('ColorUtil', function() {
	
	var ColorUtil = this;
	
	ColorUtil.colorForPlayer = function(player) {
		return '#000000';
	};

	ColorUtil.opacityForPlayer = function(player) {
		return 0.75;
	} 
	 
	 
});
