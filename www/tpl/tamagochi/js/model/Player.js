'use strict';
window.TGC = window.TGC || {};
window.TGC.Player = function(json, userJSON) {
	
	console.log('new TGC.Player()', json, userJSON);
	
	this.JSON = json;
	this.USER = userJSON;
	
	this.id = function(id) { if (id) this.JSON.p_uid = id; return this.JSON.p_uid; }
	this.user = function() { return this.USER; }
	
};
