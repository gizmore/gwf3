/**
 * Ghostwriter smarty plugin.
 * @author gizmore
 * @version 0.1
 */
(function($)
{
	var methods = {
			
		init: function(options)
		{
			// Copy settings
			var settings = {
				// Animation
				'size_left': 16,
				'size_right': 16,
				'bold_left': 400,
				'bold_right': 400,
				'opaq_left': 1.0,
				'opaq_right': 1.0,
				'color_left': '#000000',
				'color_right': '#000000',
				'style_processed': '',
				'style_unprocessed': 'zoom: 1; filter: alpha(opacity=7); opacity: 0.07;',
				'callback': function(){},
				// Speed
				'group': 2,      // group*ngroups chars at once.
				'ngroups': 12,   // group*ngroups chars at once.
				'delay': 1200,   // delay start in millis.
				'interval': 110, // timer interval in millis.
				'running': 1,
				'paused': false
			};
			return this.each(function(){
				$(this).data('ghostwriter', $.extend(settings, options));
			});
		},
		
		type: function(options)
		{
			return this.each(function(){
				var $this = $(this);
				var data = $.extend($this.data('ghostwriter'), options);
				$this.data('ghostwriter', data);
				if (_renderInit($this))
				{
					setTimeout(function(){ $this.show(); _render($this); }, data['delay']);
				}
				else
				{
					$.error('ghostwriter._renderInit failed.');
				}
			});
		},
		
		pause: function(options)
		{
			return this.each(function(){
				var $this = $(this);
				var data = $.extend($this.data('ghostwriter'), options, {'running': false});
				$this.data('ghostwriter', data);
			});
		},

		resume: function(options)
		{
			return this.each(function(){
				var $this = $(this);
				var data = $.extend($this.data('ghostwriter'), options, {'running': true});
				$this.data('ghostwriter', data);
			});
		}
	};
	
	_renderInit = function(p)
	{
		p.hide();
		p.data('ghostwriter', $.extend(p.data('ghostwriter'), {
			'text': p.html(), // Original text.
			'pos': 0, // Current pos.
			'len': 0  // Current len.
		}));
		return _checkSettings(p);
	};
	
	_checkSettings = function(p)
	{
//		var data = p.data('ghostwriter');
		return true;
	};
	
	_skipChars = function(text, pos)
	{
		var back = '';
		var len = text.length;
		var c, i;
		while (pos < len)
		{
			c = text.charCodeAt(pos);
			if (c === 32)
			{
				back += ' ';
				pos++;
			}
			else if (c === 60)
			{
				i = text.indexOf('>', pos);
				if (i === -1)
				{
					return back + text.substr(pos);
				}
				c = text.substring(pos, i+1);
				pos += c.length;
				back += c;
			}
			else
			{
				break;
			}
		}
		return back;
	};
	
	_render = function(p)
	{
		var data = p.data('ghostwriter');
		
		var text = data['text'];
		var len = text.length;
		var pos = data['pos'];
		var alen = data['len'];
		var speed = data['group'];
		var out = '', skip = '', i = 0, done = false;
		
		// Already processed.
		out += '<span style="'+ data['style_processed'] +'">'+ text.substr(0, pos) +'</span>';
		
		// Increase current length in the beginning.
		if (data['running'] === 1)
		{
			if (alen < (data['ngroups'] * speed))
			{
				alen += speed;
				data['len'] = alen;
			}
			else
			{
				data['running'] = 2;
			}
		}
		
		// Decrase current length at the end.
		else if (data['running'] === 3)
		{
			alen -= speed;
			data['len'] = alen;
			if (alen <= 0)
			{
				data['running'] = 4;
			}
		}
		
		
		// Now process current length chars.
		for (i = 0; i < alen;)
		{
			// Done?
			if (pos >= len)
			{
				data['running'] = 3;
				break;
			}
			
			// Process next char
			skip = _skipChars(text, pos);
			if (skip.length > 0)
			{
				// skip this.
				out += skip;
				pos += skip.length;
			}
			else
			{
				// Draw char.
				out += '<span style="'+ _getStyle(i, alen, data) +'">'+ text.charAt(pos++) +'</span>';
				i++;
				
				// Set current mark.
				if (i === speed) {
					data['pos'] = pos;
				}
			}
			
		}
		
		// Save state
		p.data('ghostwriter', data);
		
		// Rest
		out += '<span style="'+data['style_unprocessed']+'">'+text.substr(pos)+'</span>';
		
		// Output
		p.html(out);
		
		// Next cycle
		if (data['running'] === 4) {
			p.html(text);
			setTimeout(data['callback'], 10);
		} else {
			setTimeout(function(){_render(p);}, data['interval']);
		}
	};
	
	_getStyle = function(i, elen, data)
	{
		var style = '', f = i/(elen-1);
		
		if (data['bold_left'] !== data['bold_right'])
		{
			style += ' font-weight: '+ parseInt(((data['bold_right']-data['bold_left'])*f)+data['bold_left']) +';';
		}
		
		if (data['size_left'] !== data['size_right'])
		{
			style += ' font-size: '+ parseInt(((data['size_right']-data['size_left'])*f)+data['size_left']) +'px;';
		}
		
		if (data['opaq_left'] !== data['opaq_right'])
		{
			style += _getOpaque(data['opaq_left'], data['opaq_right'], f);
		}
		
		if (data['color_left'] !== data['color_right'])
		{
			style += ' color: '+Color.interpolate(data['color_left'], data['color_right'], f)+';';
		}
		
		return style;
	};
	
	_getOpaque = function(left, right, f)
	{
		var val = ((right-left)*f)+left;
		return ' zoom: 1; filter: alpha(opacity='+parseInt(val*100)+'); opacity: '+val.toFixed(2)+';';
	};

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
			$.error('Method '+method+' does not exist in jQuery.ghostwriter');
		}
	};
})(jQuery);
