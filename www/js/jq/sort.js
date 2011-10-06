/*===============*/
/*DEFAULT JQUERY!*/
/*===============*/
(function($)
{
	$.fn.sortElements = function()
	{
	    var sort = [].sort;
	    
	    return function(comparator, getSortable) {
	 
	        getSortable = getSortable || function(){return this;};
	 
	        var placements = this.map(function(){
	 
	            var sortElement = getSortable.call(this),
	                parentNode = sortElement.parentNode,
	 
	                // Since the element itself will change position, we have
	                // to have some way of storing its original position in
	                // the DOM. The easiest way is to have a 'flag' node:
	                nextSibling = parentNode.insertBefore(
	                    document.createTextNode(''),
	                    sortElement.nextSibling
	                );
	 
	            return function() {
	 
	                if (parentNode === this) {
	                    throw new Error(
	                        "You can't sort elements if any one is a descendant of another."
	                    );
	                }
	 
	                // Insert before flag:
	                parentNode.insertBefore(this, nextSibling);
	                // Remove flag:
	                parentNode.removeChild(nextSibling);
	 
	            };
	 
	        });
	        return sort.call(this, comparator).each(function(i){
	            placements[i].call(getSortable.call(this));
	        });
	    };
	};
	
	$.fn.sort = function(by, dir)
	{
		var comperator;
		if (typeof(by) === 'object')
		{
			comperator = by;
		}
		else
		{
			comperator = function(a, b)
			{
				var $a = $(a), $b = $(b);
				if ($a.attr(by) !== $b.attr(by))
				{
					return $a.attr(by) > $b.attr(by) ? 1 : -1;
				}
				else if ($a.css(by) !== $b.css(by))
				{
					return $a.css(by) > $b.css(by) ? 1 : -1;
				}
//				else if ($a.data(by) !== $b.data(by))
//				{
//					return $a.data(by) > $b.data(by) ? 1 : -1;
//				}
				return 0;
			};
		}
		
		if (dir === 'DESC')
		{
			comperator = function(a, b){ -comperator(a,b); };
			return
		}

		return this.sortElements(comperator);
	};
}
)(jQuery);
