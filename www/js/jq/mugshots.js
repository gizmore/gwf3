function Mugshot(options)
{
	var options = {
		'large_id': '#mugshot',
		'selector': 'a.mugshot',
		'distorter': GWF_WEB_ROOT+'img/3p/jakob/filmeffect3.gif',
		'x_offset': 240,
		'y_offset': 0,
		'scale_func': function(data) { return windowsize(data); }
	};
	
	this.init = function(_options)
	{
		options = $.extend(options, _options);
		_unbind();
		_bind();
	};
	
	_bind = function()
	{
		$(options['selector']).each(function(){
			$(this).find('img').tinyzoom('init');
			$(this).click(function(){ return _enlarge($(this)); });
		});
		return this;
	};
	
	_unbind = function()
	{
		$(options['selector']).unbind();
		$(options['selector']).click(function(){return false;});
	};
	
	_enlarge = function(a)
	{
		_unbind();
		
		// Small
		var img = a.find('img');
		var href_x = a.attr('href');
		var href_s = img.attr('src');
		var alt = img.attr('alt');
		var title = img.attr('title');
		img.data('href_s', href_s);
		a.data('href_x', href_x);
		
		// Large
		var ms = _getLarge();
		ms.html('<img class="mugshotl" src="'+href_x+'" title="'+title+'" alt="'+alt+'" />');
		var msi = ms.find('img');
		
		_distort(img);
		
		_prepareLarge(img, ms, msi);
		
		$("<img/>").attr("src", href_x).load(function() {
			_enlargeB(img, this.width, this.height);
		});
		
		return false;
	};
	
	_getLarge = function()
	{
		return $(options['large_id']);
	};
	
	_prepareLarge = function(img, ms, msi)
	{
		var pos = img.position();
		var ox = pos.left + options['x_offset'];
		var oy = pos.top + options['y_offset'];
		ms.css('top', oy+'px');
		ms.css('left', ox+'px');
		msi.css('width', img.width()+'px');
		msi.css('height', img.height()+'px');
		ms.show();
	};
	
	_distort = function(img)
	{
		img.attr('src', options['distorter']);
		img.css('css', 'background-size: 100%');
		img.css('width', img.data('old_w')+'px');
		img.css('height', img.data('old_h')+'px');
	};
	
	_enlargeB = function(img, dw, dh)
	{
		var ms = _getLarge();
		var msi = ms.find('img');

		// Window
//		var ww = $(window).width();
//		var wh = $(window).height();
//		var sx = $(window).scrollLeft();
//		var sy = $(window).scrollTop();
		
		// Origin
//		var pos = img.position();
//		var oy = pos.top;// + 155;
//		var ox = pos.left + 240;
//		var ow = img.width();
//		var oh = img.height();

		// Aspect Ratio
//		var ax = dw / ww;
//		var ay = dh / wh;
//		
//		var awh = dw / dh;
//		var ahw = dh / dw;
		
		var data = {'image':img, 'width':dw, 'height':dh};
		
		var dest = options['scale_func'].call(this, data);
		
//		// Destination image width too large. Scale to screen width.
//		if (dw > ww)
//		{
//			var rw = dw - ww;
//			dw -= rw;
//			var rh = rw * ahw;
//			dh -= rh;
//		}
//		
//		// Destinaion image too high. Offset and keep.
//		if (dh > wh)
//		{
//			sy += (dh-wh)/2; // TODO: (currently just y offset and keep full image size)
//		}
//		
//		var dx = (ww - dw) / 2 + sx;
//		var dy = (wh - dh) / 2 + sy;
		
		ms.animate({
			'left': dest['x']+'px',
			'top': dest['y']+'px'
		}, 700, function() {} );
		
		msi.animate({
			'width': dest['w']+'px',
			'height': dest['h']+'px'
		}, 700, function() { msi.click(function() { return _unmug(ms, msi, img); }); } );
		
		return false;
	};
	
	_unmug = function(ms, msi, img)
	{
		var pos = img.position();
		var oy = pos.top + options['y_offset'];
		var ox = pos.left + options['x_offset'];
		var ow = img.width();
		var oh = img.height();

		msi.unbind();
		ms.animate({
			'left': ox+'px',
			'top': oy+'px'
		}, 300, function() {} );
		msi.animate({
			'width': ow+'px',
			'height': oh+'px'
		}, 300, function() { ms.hide(); msi.hide();  _restore(img); _bind(); } );
	};
	

	_restore = function(img)
	{
		img.attr('src', img.data('href_s'));
		img.attr('width', img.data('old_w'));
		img.attr('height', img.data('old_h'));
	};
	
	/**
	 * This scale function will zoom the image to original size, unless it doesn't fit into window width.
	 * Else it scales to window width, keeping the aspect ratio.
	 */
	this.highres = function(data)
	{
		var dw = data['width'];
		var dh = data['height'];
		
		var ww = $(window).width();
		var wh = $(window).height();
		var sx = $(window).scrollLeft();
		var sy = $(window).scrollTop();
		
		// Destination image width too large. Scale to screen width.
		if (dw > ww)
		{
			var ahw = dh / dw;
			var rw = dw - ww;
			dw -= rw;
			var rh = rw * ahw;
			dh -= rh;
		}
		
		// Destinaion image too high. Offset and keep.
		if (dh > wh)
		{
			sy += (dh-wh) / 2;
		}

		var dx = (ww - dw) / 2 + sx;
		var dy = (wh - dh) / 2 + sy;
		
		return {'x':dx, 'y':dy, 'w':dw, 'h':dh};
	};
	
	/**
	 * This scale function will zoom the image to the window size
	 */
	this.windowsize = function(data)
	{
		var ww = $(window).width();
		var wh = $(window).height();
		return this.boxsize(data, 0, 0, ww, wh);
	};
	
	this.box = function(data, box)
	{
		return this.boxsize(data, box.position().left, box.position().top, box.width(), box.height());
	};
	
	this.boxsize = function(data, x, y, w, h)
	{
		// Image dimension
		var iw = data['width'];
		var ih = data['height'];

		// Viewport
//		var sx = $(window).scrollLeft();
//		var sy = $(window).scrollTop();

		// Aspect Ratio
		var ax = iw / ih;
		var ay = ih / iw;
		
		// Overlap
		var subx = iw - w;
		var suby = ih - h;
		
		if (subx > 0 && suby > 0)
		{
			if (ax > ay)
			{
				var oldh = h;
				h = w * ay;
				y += (oldh-h)/2;
			}
			else
			{
				var oldw = w;
				w = h * ax;
				x += (oldw-w)/2;
			}
		}
		else if (subx > 0)
		{
			var oldh = h;
			h = w * ay;
			y += (oldh-h)/2;
		}
		else if (suby > 0)
		{
			var oldw = w;
			w = h * ax;
			x += (oldw-w)/2;
		}
		
		return {'x':x, 'y':y, 'w':w, 'h':h};
	};
	
	return this.init(options);
}