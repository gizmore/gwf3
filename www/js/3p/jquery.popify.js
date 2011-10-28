(function($) {
	$.fn.extend({

		popify: function( options ) {
		
		var index = 1;
					
			return this.each(function() {
			
				$(this).click(function( event )
				{
				
					event.preventDefault();
					var url = $(this).attr('href');
					var classes = $(this).attr('class');
					var rel = $(this).attr('rel');
					
					var profiles =
					{
						small:
						{
							width: 300,
							height: 300
						},
						large:
						{
							width: 650,
							height: 800
						},
						all:
						{
							createnew:1,
							menubar:1,
							toolbar:1,
							scrollbars:1,
							location:1,
							status:1,
							resizable:1,
							center:1,
							focused: false,
							forceresize: false
						}
					};	
					
					var defaults = {
				
						width:500, 
				
						height:600, 
			
						top:48,
			
						left:48,
					
						createnew:0, 
			
						menubar:0,	
				
						toolbar:0,
					
						scrollbars:0,
				
						location:0,						
			
						status:0,
		
						resizable:0,
		
						center:0,
		
						close:true,

						refresh: false,
						
						focused: true,
						
						forceresize: true,
						
						element: ''
					};
				
					settings = $.extend( defaults, options );
					
					popupOpen(classes);
		
					function popupOpen(classes) 
					{
						var currentClasses = classes;
						
						for ( var i in profiles )
						{
							if (currentClasses.match(i))
							{
								var profile = i;
								break;
							}
						}
					
						if ( profile != undefined )
						{
							settings = $.extend( defaults, profiles[profile] );
						}
						
						if ( rel != '' )
						{
							var relObject = {};
							var relSettings = rel.replace(/\s+/g,':').split(':');
							for (var i = 0; i < relSettings.length; i += 2)
							{
								next = i + 1;
								relObject[relSettings[i]] = relSettings[next];
							}
							settings = $.extend( defaults, relObject );
						}		
						if ( currentClasses.match(/opener/) )
						{
							if ( settings.refresh == true )
							{
								window.opener.location.href = window.opener.location.href;
							}
							else
							{
								window.opener.location = url;
							}
							
							if ( settings.close == true )
							{
								self.close();
							}
						}
						else if ( currentClasses.match(/close/) )
						{
							self.close();
						}
						else
						{
							var name, opened, parameters = '';
							if ( settings.center == 1 )
							{
								settings.top = ( ((window.screen.height - settings.height) / 2) - 40 );
								settings.left = ( window.screen.width-settings.width ) / 2;
							}
						
							parameters = "location=" + settings.location + ",menubar=" + settings.menubar + ",height=" + settings.height + ",width=" + settings.width + ",toolbar=" + settings.toolbar + ",scrollbars=" + settings.scrollbars  + ",status=" + settings.status + ",resizable=" + settings.resizable + ",left=" + settings.left + ",top=" + settings.top + ",screenX=" + settings.left  + ",screenY=" + settings.top;
							
							name = ( settings.createnew == '1' ) ? ( 'Popify'+index ) : ( 'Popify' );
							
							if ( window.focus && settings.focused == true )
							{
								opened = window.open(url,name,parameters);
								opened.focus();
							}
							else
							{
								opened = window.open(url,name,parameters);
								opened.opener.focus();
							}
							
							if ( window.focus && settings.element != '')
							{
								opened.focus();
								opened.onload = function() { 
									$(settings.element, opened.document).focus(); 
								}
							}
							
							if ( settings.createnew != '1' && name == 'Popify' && settings.forceresize == true)
							{
								$(opened).ready(function() {
								
								var windowWidth = parseInt(settings.height);
								var windowHeight = parseInt(settings.width);
							
								opened.resizeTo(windowWidth + 8, windowHeight + 80);
							
								});
							}
							index++;
							
						}
					}
				});
			});
			
		}
	});
})(jQuery);