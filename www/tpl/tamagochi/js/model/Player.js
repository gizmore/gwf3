'use strict';
window.TGC = window.TGC || {};
window.TGC.Player = function(json, userJSON, secret) {
	
	console.log('new TGC.Player()', json, userJSON);
	
	this.JSON = json;
	this.USER = userJSON;
	this.SECRET = secret;
	
	this.lat = function() { return this.latitude; };
	this.lon = function() { return this.longitude; };
	this.move = function(lat, lng) { this.latitude = lat; this.longitude = lng; };
	
	this.user = function() { return this.USER; };
	this.secret = function() { return this.SECRET; };

	this.id = function(id) { if (id) this.JSON.p_uid = id; return this.JSON.p_uid; };
	this.isOwn = function() { return this.id() > 0; };

	this.name = function(name) { if (name) this.JSON.name = name; return this.JSON.name; };
	this.gender = function(gender) { if (gender) this.JSON.gender = gender; return this.JSON.gender; };

	this.mode = function(mode) { if (mode) this.JSON.m = mode; return this.JSON.m; };
	this.color = function(color) { if (color) this.JSON.c = color; return this.JSON.c; };
	this.skill = function(skill) { if (skill) this.JSON.s = skill; return this.JSON.s; };
	this.element = function(element) { if (element) this.JSON.e = element; return this.JSON.e; };
	
	this.lastModeChange = function(lastChange) { if (lastChange) this.JSON.mc = lastChange; return this.JSON.mc };
	this.lastColorChange = function(lastChange) { if (lastChange) this.JSON.cc = lastChange; return this.JSON.cc };
	this.lastSkillChange = function(lastChange) { if (lastChange) this.JSON.sc = lastChange; return this.JSON.sc };
	this.lastElementChange = function(lastChange) { if (lastChange) this.JSON.ec = lastChange; return this.JSON.ec };
	
	this.lastSlap = function() {};
};
