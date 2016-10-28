'use strict';
var TGC = angular.module('tgc');
TGC.service('ConstSrvc', function() {

	var ConstSrvc = this;

	ConstSrvc.IN_LOGIN = false;
	ConstSrvc.inLogin = function(bool) { if (bool !== undefined) ConstSrvc.IN_LOGIN = bool; return ConstSrvc.IN_LOGIN };

});
