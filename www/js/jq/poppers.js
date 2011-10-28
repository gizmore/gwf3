(function($)
{
	var drag_x = -1;
	var drag_y = -1;


	$.fn.poppersDrag = function(handle_selector)
	{
		this.parent = null;
		this.handle = null;
		this.init = function()
		{
			this.handle.bind('mouseup', function(event){ this.mouseup(event, this.handle, this.parent); });
			this.handle.bind('mousemove', function(event){ this.mousemove(event, this.handle, this.parent); });
//			alert(this);
		};
		
		this.mouseup = function(event, handle, parent)
		{
			console.log(event);
//			alert(handle);
//			alert(parent);
			drag_x = -1;
			drag_y = -1;
			kd_input.clearButtons();
		};
		
		this.mousedown = function(event, handle, parent)
		{
			console.log(event);
			drag_x = event.pageX;
			drag_y = event.pageY;
		};
		
		this.mousemove = function(event, handle, parent)
		{
			console.log(event);
			console.log(parent);
//			var e = kd_input.convertEvent(parent, event);
			if (kd_input.isDragging(event))
			{
				var x = parent.position().x;
				var y = parent.position().y;
				var dx = event.pageX - drag_x;
				var dy = event.pageY - drag_y;
				drag_x = event.pageX;
				drag_y = event.pageY;
				parent.css('left', (x+dx)+"px");
				parent.css('top', (y+dy)+"px");
			}
//			alert(handle);
//			alert(parent);
		};

		if (handle_selector === undefined)
		{
			this.handle = this;
		}
		else
		{
			this.handle = this.find(handle_selector);
			if (this.handle.length === 0)
			{
				this.handle = this;
			}
		}
		

		
		this.each(init);
	};
})(jQuery);
