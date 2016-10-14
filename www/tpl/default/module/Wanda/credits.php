<script type="text/javascript">

$(function(){
	
	window.CREDITS = {};
	window.CREDITS.width = <?php echo $tVars['width']; ?>;
	window.CREDITS.height = <?php echo $tVars['height']; ?>;
	window.CREDITS.scrollText = '<?php echo $tVars['scrollText']; ?>';

	window.CREDITS.init = function() {
		var content = $('<div id="crid"></div>');
		var CC = window.CREDITS;
		for (var y = 0; y <= CC.width; y++) {
			var row = $('<div id="crow_"'+y+'></div>');
			crid.addChild();
			for (var x = 0; x <= CC.width; x++) {
				row.addChild($('<div id="clet_'+y+'_'+x+'"></div>'));
			}
			content.addChild(row);
		}
		$(document).addChild(content);
			 
	};

	window.CREDITS.init();
});




</script>

<pre>
~o´
</pre>
