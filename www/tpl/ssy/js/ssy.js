function ssyResize()
{
	var w_newWidth, w_newHeight;
	var w_maxWidth = 1600, w_maxHeight = 1200;
	
	if (navigator.appName.indexOf("Microsoft") != -1)
	{
		w_newWidth=document.body.clientWidth;
		w_newHeight=document.body.clientHeight;
	} else {
		var netscapeScrollWidth = 0; /*15;*/
		w_newWidth=window.innerWidth-netscapeScrollWidth;
		w_newHeight=window.innerHeight-4; /*netscapeScrollWidth;*/
	}
	if (w_newWidth > w_maxWidth)
		w_newWidth = w_maxWidth;
	if (w_newHeight > w_maxHeight)
		w_newHeight = w_maxHeight;
	var applet = document.getElementById('ssy_applet2');
	applet.width = w_newWidth;
	applet.height = w_newHeight;
//	window.scroll(0,0);
}

function ssyHideElement(e)
{
	e.style.display = "none";
}

function ssyHideElements(name)
{
	var es = document.getElementsByName(name);
	var len = es.length;
	for (var i = 0; i < len; i++)
	{
		ssyHideElement(es[i]);
	}
}
