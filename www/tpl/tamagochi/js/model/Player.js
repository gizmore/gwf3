'use strict';
window.TGC = window.TGC || {};
window.TGC.Player = function(json) {
	
	this.JSON = json;
	
	this.id = function(id) { if (id) this.JSON.p_id = id; return this.JSON.p_id; }
	
};
