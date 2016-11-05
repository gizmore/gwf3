'use strict';
var TGC = angular.module('tgc');
TGC.service('ConstSrvc', function() {

	var ConstSrvc = this;

	ConstSrvc.IN_LOGIN = false;
	ConstSrvc.inLogin = function(bool) { if (bool !== undefined) ConstSrvc.IN_LOGIN = bool; return ConstSrvc.IN_LOGIN };
	
	ConstSrvc.SKILL_SHAPE_RADIUS_LAT_MIN = 0.005;
	ConstSrvc.SKILL_SHAPE_RADIUS_LNG_MIN = 0.005;
	ConstSrvc.SKILL_SHAPE_RADIUS_LAT_MAX = 0.100;
	ConstSrvc.SKILL_SHAPE_RADIUS_LNG_MAX = 0.100;

	ConstSrvc.LEVELS = ['none'];
	ConstSrvc.MAX_LEVEL = 0;
	
	ConstSrvc.initLevels = function(levels) {
		ConstSrvc.LEVELS = levels;
		ConstSrvc.MAX_LEVEL = ConstSrvc.LEVELS.length - 1;
		if (ConstSrvc.MAX_LEVEL < 1) {
			ConstSrvc.MAX_LEVEL = 1;
		}
	};
	
	ConstSrvc.initLevels(window.TGCConfig.levels);

});
