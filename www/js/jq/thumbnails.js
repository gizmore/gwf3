function Thumbnails() //id_div, class_img, displaycount, width, height, zoom, img_left, img_right)
{
	var div = null;
	var thumbs = this; // Singleton?

	// Private vars
	var id_div = ''; // The main thumbnail div id. Example #thumbnail 
	var id_img = ''; // The images selector. Example div.#thumbnail img.thumbnail
	var count = 2; // Num images simultaniously shown.
	var btn_w = 32; 
	var btn_h = 32;
	var width = 0;// Sync to width, when set.
	var height = 0; // Sync to height, when set.
	var zoom = 1.25; // Zoom factor. 1.0 is off.
	var images = new Array(); // Precached images array.
	var c_x = 0; // current image
	var zoom_in_ms = 500; // animation speed
	var zoom_out_ms = 500; // animation speed
	var img_left = GWF_WEB_ROOT+'img/default/arrow_left.png';
	var img_right = GWF_WEB_ROOT+'img/default/arrow_right.png';

	var max_x = -1; // c_x + count;
	
	this.setCount = function(_count)
	{
		var c = parseInt(_count);
		if (count < 1)
		{
			throw 'Invalid value for setCount: '+_count;
			return false;
		}
		count = _count;
		return this;
	};
	
	this.instance = function(_id_div, _id_img, _count)
	{
		div = $(_id_div);
		if (!div.length)
		{
			throw 'Cannot find element with the id: '+id_div;
			return false;
		}
		id_div = _id_div;
		id_img = _id_img;
		return this.setCount(_count);
	};
	
	this.setButtons = function(_img_left, _img_right, w, h)
	{
		img_left = _img_left;
		img_right = _img_right;
		btn_w = w ? w : 32;
		btn_h = h ? h : 32;
		return this;
	};
	
	this.init = function()
	{
		var div = $(id_div);
		
		
		// Add scroll buttons
		div.html(
			'<div><img class="thumbs_left" src="'+img_left+'" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
			'<img class="thumbs_right" src="'+img_right+'" /></div>'+
			div.html()
		);
		var bl = $('.thumbs_left');
		var br = $('.thumbs_right');
		bl.unbind(); br.unbind();
		bl.click(function(){return thumbs.moveLeft();}); br.click(function(){return thumbs.moveRight();});
		bl.width(btn_w); br.width(btn_w);
		bl.height(btn_h); br.height(btn_h);
		
		// Add all images
		$(id_img).each(function(){ images.push($(this)); });
		if (images.length === 0)
		{
			return this;
		}
		var max_x = c_x + count;
		
		for (var i in images)
		{
			images[i].load(function(){
				$(this).click(function(){thumbs.restore($(this));});
				$(this).mouseout(function(){thumbs.stopZoom($(this));});
				$(this).mouseover(function(){thumbs.startZoom($(this));});
			});
			images[i].tinyzoom('init');
			if ( (i < c_x) || (i >= max_x) )
			{
				images[i].hide();
			}
		}
		return this;
	};
	
	
	/*------------------------//
	// --- Zoom Functions --- //
	//------------------------*/
	this.startZoom = function(img)
	{
		img.tinyzoom('zoomIn', zoom, zoom_in_ms);
	};
	
	this.stopZoom = function(img)
	{
		img.tinyzoom('zoomBack', zoom_out_ms);
	};
	
	this.restore = function(img)
	{
		img.tinyzoom('restore');
	};
	
	this.moveLeft = function()
	{
		if (c_x > 0)
		{
			c_x--;
			this.refresh();
		}
	};
	
	this.moveRight = function()
	{
		if (c_x < (images.length-count))
		{
			c_x++;
			this.refresh();
		}
	};
	
	this.refresh = function()
	{
		var max_x = c_x + count;
		for (var i in images)
		{
			if ( (i < c_x) || (i >= max_x) )
			{
				images[i].hide();
			}
			else
			{
				images[i].show();
			}
		}
	};

	return this;
}
