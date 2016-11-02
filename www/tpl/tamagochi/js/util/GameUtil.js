'use strict';
var TGC = angular.module('tgc');
TGC.service('GameUtil', function() {
	
	var GameUtil = this;
	
	GameUtil.identificationString = function() {
		return sprintf('%s:%s:%s:%s', uid, username, cookie, secret);
	};
	
});
