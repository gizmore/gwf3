(function($)
{
	var methods = {
		init: function(options)
		{
			// Copy settings
			var settings = {
				'color_begin': '#ffffff',
				'color_end': '#fea965',
				'ms': 150,
				'speed': 1,
				'length': 5,
				'start_delay': 50,
			};
			return this.each(function(){
				$(this).data('ghostwriter', $.extend(settings, options));
			});
		},

		type: function(options)
		{
			return this.each(function(){
				$this = $(this);
				$this.data('ghostwriter', $.extend($this.data('ghostwriter'), options));
				_renderInit($this);
				setTimeout(function(){_render($this);}, $this.data('ghostwriter')['start_delay']);
			});
		}
	};
	
	_renderInit = function(p)
	{
		var struct = {
				'text': p.text(),
				'pos': 0
		};
		$this.data('ghostwriter', $.extend($this.data('ghostwriter'), struct));
	},
	
	_render = function(p)
	{
		var data = p.data('ghostwriter');
		
		var done = false, style='';
		var text = data['text'];
		var pos = data['pos'];
		var len = text.length;
		var out = '';
		
		// Front
		out += text.substr(0, pos++);
//		text = text.substr(pos);
		
		for (var i = 0; i < data['length']; i++)
		{
			if (pos >= len)
			{
				done = true;
				break;
			}
			var c = text.substr(pos++, 1);
			
			if (c === '<')
			{
				while (pos < len)
				{
					c = text.substr(pos++, 1);
					if (c === '>')
					{
						pos++;
						if (pos >= len)
						{
							done = true;
						}
						break;
					}
				}
			}
			
			if (done === true)
			{
				break;
			}
			
			style = '';
			out += '<span style="">'+style+'</span>';

		}
		
		// Back
		style = 'zoom: 1; filter: alpha(opacity=10); opacity: 0.1;';
		out += '<span style="'+style+'">'+text.substr(pos)+'</span>';
		
		p.html(out);
		data['pos'] = pos;
		p.data('ghostwriter', data);
		
		if (!done)
		{
			setTimeout(function(){_render(p);}, p.data('ghostwriter')['ms']);
		}
	},

	$.fn.ghostwriter = function(method, options)
	{
		if (!this.length)
		{
			return this;
		}
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
			
})(jQuery);
