/**
 * Tinyzoom by gizmore.
 * This extends jquery images to have original size values + old size values.
 * Used in Thumbnails and Mugshots to zoom into multiple states.
 * @author gizmore
 */
;(function($){
	var methods = {
		'init': function() {
		    return this.each(function(){
		    	$(this).load(function(){
			    	$this = $(this);
			    	$this.data('org_w', this.width);
		    		$this.data('org_h', this.height);
		    		$this.data('old_w', $this.width());
		    		$this.data('old_h', $this.height());
		    	});
		    });
		},
		
		'restore': function() {
			this.stop();
			this.width(this.data('old_w')+'px');
			this.height(this.data('old_h')+'px');
			return $(this);
		},
		
		'zoomIn': function(_zoom, _ms, _callback) {
			var new_w = $(this).data('old_w') * _zoom;
			var new_h = $(this).data('old_h') * _zoom;
			return this.stop().animate({
				'width': new_w+'px',
				'height': new_h+'px'
			}, _ms, _callback);
		},
		
		'zoomTo': function(x, y, w, h, _mx, _callback) {
			return this;
		},
		
		'zoomBack': function(_ms, _callback) {
			return this.stop().animate({
				'width': this.data('old_w')+'px',
				'height': this.data('old_h')+'px'
			}, _ms, _callback);
		}
	};
	
	$.fn.tinyzoom = function(method, options)
	{
		// Method calling logic
		if (methods[method])
		{
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === 'object' || !method)
		{
			return methods.init.apply(this, arguments);
		}
		else
		{
			$.error('Method '+method+' does not exist on jQuery.tinyzoom');
		}
	};
})
(jQuery);
