window.gwf = {};
window.gwf.Profile = function(mapID, userID, translations, left, is_admin, api_key, protocol)
{
	this.map = null;
	this.mapID = mapID;
	this.markers = {};
	this.userID = userID;
	this.trans = translations;
	this.loadTimer = null;
	this.loadDelay = 600;
	this.initial = true;
	this.left = left;
	this.is_admin = is_admin;
	this.api_key = api_key;
	this.protocol = protocol;
	this.mapOptions = {
		zoom: 8,
		minZoom: 7,
		maxZoom: 18, 
		center: new google.maps.LatLng(52.32227800, 10.22904400)
	};

	this.getApiKeyArg = function() { return this.api_key === '' ? '' : '&api_key='+this.api_key; };
	this.guestText = function() { return this.trans.guest; };
	this.deleteConfirmText = function() { return this.trans.remove; };
	this.poiPromptText = function() { return this.trans.rename; };
	this.errCountryText = function() { return this.trans.err_jump; };
	
	this.init = function(geolocate)
	{
		$('#jump_address').onEnterKey(this.jumpToAddress.bind(this));
		$('#poi_init').hide();
		this.resizeMap();
		this.getUserLocation(geolocate);
		$('html,body').animate({scrollTop: $('#poi_helper').offset().top}, 'slow');
	};
	
	this.getCanvas = function() { return document.getElementById(this.mapID); };

	this.calcMapWidth = function() { return '100%'; };
	this.calcMapHeight = function()
	{
		var helper = document.getElementById('poi_helper').clientHeight;
		return (document.getElementById('page_wrap').clientHeight-20-helper) + 'px';
	};
	
	this.resizeMap = function()
	{
		document.getElementById('wc_sidebar').style.display = 'none';
		var canvas = this.getCanvas();
		canvas.style.width = this.calcMapWidth();
		canvas.style.height = this.calcMapHeight();
	};
	
	this.getUserLocation = function(geolocate)
	{
		if (!geolocate)
		{
			this.initGoogle();
		}
		try
		{
			navigator.geolocation.getCurrentPosition(this.gotLocation.bind(this), this.locationFailed.bind(this));
		}
		catch (e)
		{
			this.initGoogle();
		}
	};
	
	this.initMap = function()
	{
		google.maps.event.addListener(this.map, 'click', this.onclickMap.bind(this));
		google.maps.event.addListener(this.map, 'bounds_changed', this.onmoveMap.bind(this));
    };
	
	this.onclickMap = function(event)
	{
		var descr = prompt(this.poiPromptText());
		if (descr !== null)
		{
			$.ajax(this.getAddURL(event, descr), {
				context: this,
				success: this.onAddedMarker,
				error: this.ajaxError
			});
		}
	};
	
	this.getAddURL = function(event, descr)
	{
		console.log(event);
		return GWF_WEB_ROOT + sprintf(
			"index.php?mo=Profile&me=POISAdd&lat=%f&lon=%f&pp_id=0&pp_descr=%s",
			event.latLng.lat(), event.latLng.lng(), descr
		);
	};
	this.getEditURL = function(marker)
	{
		console.log(marker);
		var descr = marker.pp_descr === null ? '' : marker.pp_descr;
		return GWF_WEB_ROOT + sprintf(
			"index.php?mo=Profile&me=POISAdd&lat=%f&lon=%f&pp_id=%d&pp_descr=%s",
			marker.position.lat(), marker.position.lng(), marker.pp_id, descr
		);
	};
	
	this.onAddedMarker = function(data, status, xhr)
	{
		this.addMarker(eval('('+data+')'));
	};

	this.onmoveMap = function()
	{
		if (this.initial === true)
		{
			this.initial = false;
			this.loadPOIs();
		}
		else
		{
			this.cancelLoad();
			this.loadTimer = setTimeout(this.loadPOIs.bind(this), this.loadDelay);
		}
	};

	this.markerTitle = function(poi)
	{
		var user = poi.user_name == null ? this.guestText() : poi.user_name;
		var desc = poi.pp_descr == null ? '' : ' - ' + poi.pp_descr;
		return user + desc;
	};
	
	this.addMarker = function(poi)
	{
		this.storePOI(poi, true);
	};
	
	this.storeMarker = function(marker)
	{
		if (this.markers[marker.pp_id] !== undefined)
		{
			this.markers[marker.pp_id].setMap(null);
		}
		this.markers[marker.pp_id] = marker;
	};
	
	this.onclickMarker = function(marker)
	{
		this.cancelRename();
		this.renameTimer = setTimeout(this.renameMarker.bind(this, marker), 1000);
	};
	
	this.cancelRename = function()
	{
		if (this.renameTimer !== null)
		{
			clearTimeout(this.renameTimer);
			this.renameTimer = null;
		}
	};

	this.renameMarker = function(marker)
	{
		var desc = prompt(this.poiPromptText());
		if (desc !== null)
		{
			marker.pp_descr = desc;
			this.saveMarker(marker);
		}
	};

	this.onmoveMarker = function(marker, event)
	{
		this.cancelRename();
		this.cancelLoad();
	};
	
	this.cancelLoad = function()
	{
		if (this.loadTimer !== null)
		{
			clearTimeout(this.loadTimer);
			this.loadTimer = null;
		}
	};

	this.onmovedMarker = function(marker, event)
	{
		console.log(marker);
		this.saveMarker(marker);
	};
	
	this.saveMarker = function(marker)
	{
		$.ajax(this.getEditURL(marker), {
			context: this,
			success: this.onAddedMarker,
			error: this.ajaxError
		});
	};
	
	this.ondblclickMarker = function(marker)
	{
		this.cancelRename();
		if (confirm(this.deleteConfirmText()))
		{
			$.ajax(this.getRemURL(marker), {
				context: this,
				success: this.onRemovedMarker,
				error: this.ajaxError
			});
		}
	};
	
	this.getRemURL = function(marker)
	{
		return GWF_WEB_ROOT + sprintf("index.php?mo=Profile&me=POISRemove&pp_id=%d", marker.pp_id);
	};
	
	this.onRemovedMarker = function(data, status, xhr)
	{
		this.deleteMarker(data);
	};
	
	this.ajaxError = function(xhr, status, error)
	{
		var text = undefined;
		try
		{
			text = xhr.responseText;
			var text = eval('('+text+')');
			if (text.error !== undefined)
			{
				text = text.error;
			}
		}
		catch (e) {}
		alert(text);
	};
	
	this.deleteMarker = function(pp_id)
	{
		if (this.markers[pp_id] !== undefined)
		{
			this.markers[pp_id].setMap(null);
			this.markers[pp_id] = undefined;
		}
	};

	this.addPOI = function(poi)
	{
		this.storePOI(poi, false);
	};
	
	this.storePOI = function(poi, editable)
	{
		var position = new google.maps.LatLng(poi.pp_lat, poi.pp_lon);
		var title = this.markerTitle(poi);
		if (this.markers[poi.pp_id] === undefined)
		{
			var marker = new google.maps.Marker({
				position: position,
				map: this.map,
				draggable: editable,
//				bound: false,
				title: title,
				pp_id: poi.pp_id,
				pp_descr: poi.pp_descr
			});		
			
			if (editable)
			{
				google.maps.event.addListener(marker, 'click', this.onclickMarker.bind(this, marker));
				google.maps.event.addListener(marker, 'dblclick', this.ondblclickMarker.bind(this, marker));
				google.maps.event.addListener(marker, 'dragend', this.onmovedMarker.bind(this, marker));
				google.maps.event.addListener(marker, 'dragstart', this.onmoveMarker.bind(this, marker));
			}

			this.storeMarker(marker);
		}
		else
		{
			var marker = this.markers[poi.pp_id];
			marker.setTitle(title);
			marker.setPosition(position);
			marker.pp_descr = poi.pp_descr;
		}
	}
	
	this.gotLocation = function(location)
	{
	    this.mapOptions.center = new google.maps.LatLng(location.coords.latitude, location.coords.longitude);
		this.initGoogle();
	};

	this.locationFailed = function(location)
	{
		this.initGoogle();
	};
	
	this.initGoogle = function()
	{
		this.map = new google.maps.Map(this.getCanvas(), this.mapOptions);
		this.initMap();
	};
	
	this.getPOIURI = function()
	{
		var bounds = this.map.getBounds();
		var ne = bounds.getNorthEast();
		var sw = bounds.getSouthWest();
		return GWF_WEB_ROOT + sprintf(
			"index.php?mo=Profile&me=POIS&minlat=%f&maxlat=%f&minlon=%f&maxlon=%f",
			sw.lat(), ne.lat(), sw.lng(), ne.lng()
		);
	};
	
	this.loadPOIs = function()
	{
		this.loadTimer = null;
		$.ajax(this.getPOIURI(), {
			context: this,
			success: this.poisLoaded,
			error: this.ajaxError
		});
	};
	
	this.poisLoaded = function(data, status, xhr)
	{
		data = eval('('+data+')');
		for (var i in data)
		{
			this.initPOI(data[i])
		}
	};
	
	this.initPOI = function(poi)
	{
		(poi.pp_uid == this.userID) || this.is_admin ? this.addMarker(poi) : this.addPOI(poi);
	};
	
	this.jumpToAddress = function()
	{
		var address = $('#jump_address').val();
		if (address !== '')
		{
			this.requestAddressLocation(address);
		}
	};
	
	this.getAddressURI = function(country)
	{
		return sprintf('%s://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false%s', this.protocol, country, this.getApiKeyArg());
	};
	
	this.requestAddressLocation = function(address)
	{
		$.ajax(this.getAddressURI(address), {
			context: this,
			success: this.gotCountryLocation,
			error: this.ajaxError
		});
	};
	
	this.noCountryLocation = function(xhr, status, error)
	{
		this.noCountryError();
	};
	
	this.noCountryError = function()
	{
		alert(this.errCountryText());
	};
	
	this.gotCountryLocation = function(data, status, xhr)
	{
		try
		{
			var loc = data.results[0].geometry.location;
			this.map.panTo(new google.maps.LatLng(loc.lat, loc.lng));
		}
		catch (e)
		{
			this.noCountryError();
		}
	};
};
