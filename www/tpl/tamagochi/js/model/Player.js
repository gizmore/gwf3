'use strict';
window.TGC = window.TGC || {};
window.TGC.Player = function(json, userJSON, secret) {
	
	console.log('new TGC.Player()', json, userJSON);
	
	this.JSON = json;
	this.USER = userJSON;
	this.SECRET = secret;
	
	this.position = null;
	
	this.lat = function() { return this.position.lat(); };
	this.lng = function() { return this.position.lng(); };
	this.moveTo = function(lat, lng) { this.position = new google.maps.LatLng({lat: lat, lng: lng}); };
	this.latLng = function() { return this.position; };
	this.hasPosition = function() { return this.position !== null; };
	this.hasStats = function() { return this.JSON.fl !== undefined; };
	
	this.user = function() { return this.USER; };
	this.secret = function() { return this.SECRET; };

	this.id = function(id) { if (id) this.JSON.p_uid = id; return this.JSON.p_uid; };
	this.isOwn = function() { return this.id() > 0; };

	this.hash = function(hash) { if (hash) this.JSON.hash = hash; return this.JSON.hash; };
	this.name = function(name) { if (name) this.JSON.name = name; return this.JSON.name; };
	this.gender = function(gender) { if (gender) this.JSON.gender = gender; return this.JSON.gender; };

	this.mode = function(mode) { if (mode) this.JSON.m = mode; return this.JSON.m; };
	this.color = function(color) { if (color) this.JSON.c = color; return this.JSON.c; };
	this.skill = function(skill) { if (skill) this.JSON.s = skill; return this.JSON.s; };
	this.element = function(element) { if (element) this.JSON.e = element; return this.JSON.e; };
	
	this.fighterLevel = function(level) { if (level) this.JSON.fl = level; return this.JSON.fl; };
	this.ninjaLevel = function(level) { if (level) this.JSON.nl = level; return this.JSON.nl; };
	this.priestLevel = function(level) { if (level) this.JSON.pl = level; return this.JSON.pl; };
	this.wizardLevel = function(level) { if (level) this.JSON.wl = level; return this.JSON.wl; };
	
	this.fighterLevelName = function() { return this.levelName(this.fighterLevel()); };
	this.ninjaLevelName = function() { return this.levelName(this.ninjaLevel()); };
	this.priestLevelName = function() { return this.levelName(this.priestLevel()); };
	this.wizardLevelName = function() { return this.levelName(this.wizardLevel()); };

	this.lastModeChange = function(lastChange) { if (lastChange) this.JSON.mc = lastChange; return this.JSON.mc };
	this.lastColorChange = function(lastChange) { if (lastChange) this.JSON.cc = lastChange; return this.JSON.cc };
	this.lastSkillChange = function(lastChange) { if (lastChange) this.JSON.sc = lastChange; return this.JSON.sc };
	this.lastElementChange = function(lastChange) { if (lastChange) this.JSON.ec = lastChange; return this.JSON.ec };
	
	this.levelName = function(level) {
		return window.TGCConfig.levels[level];
	};
	
	this.lastSlap = function() {};
	
	/** SPELLS **/
	this.NO_SCROLL_LOCK = undefined;
	this.EXTEND_MIN_ZOOM = 0;
	this.EXTEND_MAX_ZOOM = 0;
	this.DRUNK = undefined;
};
