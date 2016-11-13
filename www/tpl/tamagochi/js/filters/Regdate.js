'use strict';
var TGC = angular.module('tgc');
TGC.filter('Regdate', function() {
	return function(date) {
		return date;
	};
});
