'use strict';
window.TGC = window.TGC || {};
window.TGC.Player = function(json, userJSON, secret) {
	
	console.log('new TGC.Player()', json, userJSON);
	
	this.JSON = json;
	this.USER = userJSON;
	this.SECRET = secret;
	
	this.user = function() { return this.USER; };
	this.secret = function() { return this.SECRET; };

	this.id = function(id) { if (id) this.JSON.p_uid = id; return this.JSON.p_uid; };
	this.gender = function(gender) { if (gender) this.JSON.p_gender = gender; return this.JSON.p_gender; };
	this.mode = function(mode) { if (mode) this.JSON.p_active_mode = mode; return this.JSON.p_active_mode; };
	this.color = function(color) { if (color) this.JSON.p_active_color = color; return this.JSON.p_active_color; };
	this.element = function(element) { if (element) this.JSON.p_active_element = element; return this.JSON.p_active_element; };
	this.skill = function(skill) { if (skill) this.JSON.p_active_skill = skill; return this.JSON.p_active_skill; };
	
};
