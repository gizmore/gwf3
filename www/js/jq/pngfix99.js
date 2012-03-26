(function($){
	// 99° IE 7/8 fading PNG fix
	$.extend({
		'pngFix': function ( obj ) {
			var vs = parseFloat($.browser.version);
			if (!$.browser.msie || ($.browser.msie && vs < 7 || vs > 8)) return;
			var magic = ';-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#00FFFFFF,endColorstr=#00FFFFFF)";filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00FFFFFF,endColorstr=#00FFFFFF);zoom: 1;';
			var clone = ['background-image', 'background-position', 'background-repeat', 'width', 'height'];
			var arr = $('*').filter(function() {
				if (this.nodeName == 'IMG' && $(this).attr('src').indexOf('.png') > -1) return true;
				return (this.currentStyle ? this.currentStyle['backgroundImage'] !== 'none' : document.defaultView.getComputedStyle(this,null).getPropertyValue('background-image') !== 'none');
			});
			$(arr).each( function () {
 
				if (this.nodeName != 'IMG') {
					var ref = $(this);
					ref.wrapInner('<div class="pngfix"></div>');
					$(clone).each( function ( k, v ) {
						ref.find('.pngfix').css( v, ref.css(v) );
					});
					ref.css({'background-image':'none'});
					ref.find('.pngfix').attr('style', (''+ref.find('.pngfix').attr('style')).split(magic).join('')+magic );
				} else {
					$(this).attr('style', (''+$(this).attr('style')).split(magic).join('')+magic );
				}
			});
		}
	});
})(jQuery);
 
$(function () { $.pngFix(); });
