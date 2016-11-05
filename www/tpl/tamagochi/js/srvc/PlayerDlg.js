'use strict';
var TGC = angular.module('tgc');
TGC.service('PlayerDlg', function($q, PlayerSrvc) {
	
	var PlayerDlg = this;
	
	PlayerDlg.player = null;
	
	PlayerDlg.open = function(player) {
		console.log('PlayerDlg.show()', player);
		var d = $q.defer();
		if (PlayerDlg.player) {
			d.reject();
		}
		else {
//			PlayerDlg.player = player;
			PlayerSrvc.withStats(player).then(function(player){
				console.log('HIIII', player);
			});
			d.resolve();
		}
		return d.promise;
	};
	
});
