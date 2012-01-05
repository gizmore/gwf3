/**
 * CURL PAGES!
 * 
 * 
 * cvi_curl_lib.js 1.4 (10-Aug-2010) (c) by Christian Effenberger 
 * All Rights Reserved. Source: curl.netzgesta.de
 * Distributed under Netzgestade Non-commercial Software License Agreement.
 * This license permits free of charge use on non-commercial 
 * and private web sites only under special conditions. 
 * Read more at... http://www.netzgesta.de/cvi/LICENSE.html

 * syntax:
	cvi_curl.defaultSize = 33; 		//INT  1-100 (%)
	cvi_curl.defaultShadow = 66;  	//INT  1-100 (% opacity)
	cvi_curl.defaultColor = 0; 		//STR '#000000'-'#ffffff' or 0
	cvi_curl.defaultInvert = false; //BOOLEAN
	
	depends on: cvi_filter_lib.js
		cvi_curl.defaultFilter = null;//OBJ [{f='grayscale'},{f='emboss', s:1}...]
		
	cvi_curl.remove( image );
	cvi_curl.add( image, options );
	cvi_curl.modify( image, options );
	cvi_curl.add( image, { size: value, shadow: value, color: value, invert: value } );
	cvi_curl.modify( image, { size: value, shadow: value, color: value, invert: value } );
 *
**/


function clipCurl(ctx,x,y,w,h,r,i) {
	ctx.beginPath();
	ctx.moveTo(x,h); ctx.quadraticCurveTo(x+r,h,x+r,h-r); ctx.quadraticCurveTo(x+r,y+(2*r),x,y); ctx.quadraticCurveTo(x+(2*r),y+r,w-r,y+r); ctx.quadraticCurveTo(w,y+r,w,y); ctx.quadraticCurveTo(w,y+(r/2),w-(r-i),y+i); ctx.lineTo(x+i,h-(r-i)); ctx.quadraticCurveTo(x+(r/2),h,x,h);
	ctx.closePath();
}

function clipReversCurl(ctx,x,y,w,h,r,i) {
	ctx.beginPath();
	ctx.moveTo(0,0); ctx.lineTo(0,h); ctx.lineTo(x,h); ctx.quadraticCurveTo(x+r,h,x+r,h-r); ctx.quadraticCurveTo(x+r,y+(2*r),x,y); ctx.quadraticCurveTo(x+(2*r),y+r,w-r,y+r); ctx.quadraticCurveTo(w,y+r,w,y); ctx.lineTo(w,0); 
	ctx.closePath();
}

function clipInversCurl(ctx,x,y,w,h,r,i) {
	ctx.beginPath();
	ctx.moveTo(w,y); ctx.quadraticCurveTo(w,y+(r/2),w-(r-i),y+i); ctx.lineTo(x+i,h-(r-i)); ctx.quadraticCurveTo(x+(r/2),h,x,h); ctx.lineTo(w,h); 
	ctx.closePath();
}

function clipCurlShadow(ctx,x,y,w,h,r,i) {
	ctx.beginPath();
	ctx.moveTo(w,y); ctx.quadraticCurveTo(w,y+(r/2),w-(r-i),y+i); ctx.lineTo(x+i,h-(r-i)); ctx.quadraticCurveTo(x+(r/2),h,x,h); ctx.lineTo(w,h);
	ctx.closePath();
}

function curlShadow(ctx,s,r,i,o) {
	var style; var f = 1.27;
	style = ctx.createRadialGradient(i,r,0,i,r,i); style.addColorStop(0,'rgba(0,0,0,'+o+')'); style.addColorStop(1,'rgba(0,0,0,0)');
	ctx.fillStyle = style; ctx.beginPath(); ctx.rect(0,i,r,i); ctx.closePath(); ctx.fill();	
	style = ctx.createLinearGradient(0,0,r,0); style.addColorStop(0,'rgba(0,0,0,0)'); style.addColorStop(0.5,'rgba(0,0,0,'+o+')'); style.addColorStop(1,'rgba(0,0,0,0)');
	ctx.fillStyle = style; ctx.beginPath(); ctx.rect(0,i+i,r,(s*f)-i-i); ctx.closePath(); ctx.fill();
	style = ctx.createRadialGradient(i,(s*f),0,i,(s*f),i); style.addColorStop(0,'rgba(0,0,0,'+o+')'); style.addColorStop(1,'rgba(0,0,0,0)');
	ctx.fillStyle = style; ctx.beginPath(); ctx.rect(0,(s*f),r,i); ctx.closePath(); ctx.fill();
}

function hextorgb(val) {
	function hex2dec(hex){return(Math.max(0,Math.min(parseInt(hex,16),255)));}
	var cr=hex2dec(val.substr(1,2)),cg=hex2dec(val.substr(3,2)),cb=hex2dec(val.substr(5,2));
	return 'rgb('+cr+','+cg+','+cb+')';
}

var cvi_curl = {
	defaultSize : 33,
	defaultShadow : 66,
	defaultColor : 0,
	defaultInvert : false,
	defaultFilter : null,
	defaultCallback : null,
	add: function(image, options) {
		if(image.tagName.toUpperCase() == "IMG") {
			var defopts = { "size" : cvi_curl.defaultSize, "shadow" : cvi_curl.defaultShadow, "color" : cvi_curl.defaultColor, "invert" : cvi_curl.defaultInvert, "filter" : cvi_curl.defaultFilter, "callback" : cvi_curl.defaultCallback }
			if(options) {
				for(var i in defopts) { if(!options[i]) { options[i] = defopts[i]; }}
			}else {
				options = defopts;
			}
			var imageWidth  = ('iwidth'  in options) ? parseInt(options.iwidth)  : image.width;
			var imageHeight = ('iheight' in options) ? parseInt(options.iheight) : image.height;
			try {
				var object = image.parentNode; 
				if(document.all&&document.namespaces&&!window.opera&&(!document.documentMode||document.documentMode<9)) {
					if(document.namespaces['v']==null) {
						var e=["shape","shapetype","group","background","path","formulas","handles","fill","stroke","shadow","textbox","textpath","imagedata","line","polyline","curve","roundrect","oval","rect","arc","image"],s=document.createStyleSheet(); 
						for(var i=0; i<e.length; i++) {s.addRule("v\\:"+e[i],"behavior: url(#default#VML);");} document.namespaces.add("v","urn:schemas-microsoft-com:vml");
					}
					var display = (image.currentStyle.display.toLowerCase()=='block')?'block':'inline-block';        
					var canvas = document.createElement(['<var style="zoom:1;overflow:hidden;display:' + display + ';width:' + imageWidth + 'px;height:' + imageHeight + 'px;padding:0;">'].join(''));
					var flt =  image.currentStyle.styleFloat.toLowerCase();
					display = (flt=='left'||flt=='right')?'inline':display;
					canvas.options = options;
					canvas.dpl = display;
					canvas.id = image.id;
					canvas.alt = image.alt;
					canvas.name = image.name;
					canvas.title = image.title;
					canvas.source = image.src;
					canvas.className = image.className;
					canvas.style.cssText = image.style.cssText;
					canvas.height = imageHeight;
					canvas.width = imageWidth;
					object.replaceChild(canvas,image);
					cvi_curl.modify(canvas, options);
				}else {
					var canvas = document.createElement('canvas');
					if(canvas.getContext("2d")) {
						canvas.options = options;
						canvas.id = image.id;
						canvas.alt = image.alt;
						canvas.name = image.name;
						canvas.title = image.title;
						canvas.source = image.src;
						canvas.className = image.className;
						canvas.style.cssText = image.style.cssText;
						canvas.style.height = imageHeight+'px';
						canvas.style.width = imageWidth+'px';
						canvas.height = imageHeight;
						canvas.width = imageWidth;
						object.replaceChild(canvas,image);
						cvi_curl.modify(canvas, options);
					}
				}
			} catch (e) {
			}
		}
	},
	
	modify: function(canvas, options) {
		try {
			var size = (typeof options['size']=='number'?options['size']:canvas.options['size']); canvas.options['size']=size;
			var shadow = (typeof options['shadow']=='number'?options['shadow']:canvas.options['shadow']); canvas.options['shadow']=shadow;
			var color = (typeof options['color']=='string'?options['color']:canvas.options['color']); canvas.options['color']=color;
			var invert = (typeof options['invert']=='boolean'?options['invert']:canvas.options['invert']); canvas.options['invert']=invert;
			var filter = (typeof options['filter']=='object'?options['filter']:canvas.options['filter']); canvas.options['filter']=filter;
			var callback = (typeof options['callback']=='string'?options['callback']:canvas.options['callback']); canvas.options['callback']=callback;
			var isize = size==0?0.33:size/100; var ishadow = shadow==0?0.66:shadow/100;
			var icolor = 0; if(isNaN(color)) {icolor = hextorgb(color);}
			var ih = canvas.height; var iw = canvas.width; var cs = Math.floor(Math.min(iw,ih)*isize);
			var or = Math.floor(cs*0.15); var hr = Math.floor(or*0.5); var ir = Math.floor(or*0.8); 
			var vr = Math.floor(or*0.25); var qr = Math.round(vr*0.25); var st = ''; var t;
			var ss = Math.floor(or*0.3); var xr = Math.floor(or*0.75); var yr = Math.floor(or*0.4);
			var hs = Math.floor(cs*0.5); var vs = Math.floor(cs*0.25); var dg = (Math.PI*90/180);
			var head, foot, shadow='', shade='', shine='', back='', fill='', strok='';
			if(document.all&&document.namespaces&&!window.opera&&(!document.documentMode||document.documentMode<9)) {
				if(canvas.tagName.toUpperCase() == "VAR") {
					head = '<v:group style="zoom:1;display:'+canvas.dpl+';margin:0;padding:0;position:relative;width:'+iw+'px;height:'+ih+'px;" coordsize="'+iw+','+ih+'"><v:rect strokeweight="0" filled="t" stroked="f" fillcolor="#ffffff" style="zoom:1;padding:0;position:absolute;top:0px;left:0px;width:'+iw+'px;height:'+ih+'px;"><v:fill color="#ffffff" opacity="0.0" /></v:rect>';
					if(invert) {
						shadow = '<v:shape strokeweight="0" filled="t" stroked="f" fillcolor="#808080" coordorigin="0,0" coordsize="'+iw+','+ih+'" path="m 0,'+ih+' l '+(iw-cs+yr)+','+ih+' c '+(iw-cs+yr)+','+ih+','+(iw-cs+yr)+','+ih+','+(iw-cs+xr)+','+(ih-vr)+' l '+(iw-vr)+','+(ih-cs+xr)+' c '+iw+','+(ih-cs+yr)+','+iw+','+(ih-cs+yr)+','+iw+','+(ih-cs)+' l '+iw+',0,'+iw+','+ih+' x e" style="position:absolute;top:0px;left:0px;width:'+iw+'px;height:'+ih+'px;"><v:fill src="'+canvas.source+'" type="frame" /></v:shape>'; 
						back = '<v:shape strokeweight="0" filled="t" stroked="f" fillcolor="#000000" coordorigin="0,0" coordsize="'+cs+','+cs+'" path="m '+hr+','+(cs-hr)+' l '+hr+','+(cs-hr-hr)+','+(cs-hr-hr)+','+hr+','+(cs-hr)+','+hr+' x e" style="position:absolute;top:'+(ih-cs+qr)+'px;left:'+(iw-cs+qr)+'px;width:'+cs+'px;height:'+cs+'px;filter:Alpha(opacity='+(ishadow*136)+'), progid:dxImageTransform.Microsoft.Blur(PixelRadius='+ss+',MakeShadow=false);"><v:fill color="#000000" /></v:shape>'; 
					}else {
						back = '<v:shape strokeweight="0" filled="t" stroked="f" fillcolor="#808080" coordorigin="0,0" coordsize="'+iw+','+ih+'" path="m 0,0 l 0,'+ih+' c '+(iw-cs+yr)+','+ih+','+(iw-cs+yr)+','+ih+','+(iw-cs+xr)+','+(ih-vr)+' l '+(iw-vr)+','+(ih-cs+xr)+' c '+iw+','+(ih-cs+yr)+','+iw+','+(ih-cs+yr)+','+iw+',0 x e" style="position:absolute;top:0px;left:0px;width:'+iw+'px;height:'+ih+'px;"><v:fill src="'+canvas.source+'" type="frame" /></v:shape>'; 
						shadow = '<v:shape strokeweight="0" filled="t" stroked="f" fillcolor="#000000" coordorigin="0,0" coordsize="'+cs+','+cs+'" path="m '+hr+','+(cs-hr)+' l '+hr+','+hr+','+(cs-hr)+','+hr+' x e" style="position:absolute;top:'+(ih-cs+qr)+'px;left:'+(iw-cs+qr)+'px;width:'+cs+'px;height:'+cs+'px;filter:Alpha(opacity='+(ishadow*136)+'), progid:dxImageTransform.Microsoft.Blur(PixelRadius='+ss+',MakeShadow=false);"><v:fill color="#000000" /></v:shape>'; 
					}
					if(isNaN(icolor)||invert>0) {
						icolor = (!isNaN(icolor)?"#808080":icolor);
						fill = '<v:shape strokeweight="0" filled="t" stroked="f" fillcolor="#808080" coordorigin="0,0" coordsize="'+cs+','+cs+'" path="m 0,0 c '+ir+','+vs+','+or+','+hs+','+or+','+(cs-or)+' qy 0,'+cs+' c '+yr+','+cs+','+yr+','+cs+','+xr+','+(cs-vr)+' l '+(cs-vr)+','+xr+' c '+cs+','+yr+','+cs+','+yr+','+cs+',0 qy '+(cs-or)+','+or+' c '+hs+','+or+','+vs+','+ir+',0,0 x e" style="position:absolute;top:'+(ih-cs)+'px;left:'+(iw-cs)+'px;width:'+cs+'px;height:'+cs+'px;"><v:fill color="'+icolor+'" /></v:shape>'; shine = ''; strok = '';
					}else {
						if(iw>ih) {f=(ih/iw); t=(1-f)+((1-isize)*f); l=1-isize;}else if(ih>iw) {t=1-isize; f=(iw/ih); l=(1-f)+((1-isize)*f); }else {t=1-isize; l=1-isize;}
						fill = '<v:shape strokeweight="0" filled="t" stroked="f" fillcolor="#808080" coordorigin="0,0" coordsize="'+cs+','+cs+'" path="m 2,2 c '+ir+','+vs+','+or+','+hs+','+or+','+(cs-or)+' qy 0,'+cs+' c '+yr+','+cs+','+yr+','+cs+','+(xr+1)+','+(cs-vr+1)+' l '+(cs-vr+1)+','+(xr+1)+' c '+cs+','+yr+','+cs+','+yr+','+cs+',0 qy '+(cs-or)+','+or+' c '+hs+','+or+','+vs+','+ir+',2,2 x e" style="rotation:180; filter:fliph() progid:DXImageTransform.Microsoft.BasicImage(rotation=1);position:absolute;top:'+(ih-cs)+'px;left:'+(iw-cs)+'px;width:'+cs+'px;height:'+cs+'px;"><v:fill src="'+canvas.source+'" origin="'+t+','+l+'" type="tile" /></v:shape>';
						shine = '<v:shape strokeweight="0" filled="t" stroked="f" fillcolor="#808080" coordorigin="0,0" coordsize="'+cs+','+cs+'" path="m 0,0 c '+ir+','+vs+','+or+','+hs+','+or+','+(cs-or)+' qy 0,'+cs+' c '+yr+','+cs+','+yr+','+cs+','+xr+','+(cs-vr)+' l '+(cs-vr)+','+xr+' c '+cs+','+yr+','+cs+','+yr+','+cs+',0 qy '+(cs-or)+','+or+' c '+hs+','+or+','+vs+','+ir+',0,0 x e" style="position:absolute;top:'+(ih-cs)+'px;left:'+(iw-cs)+'px;width:'+cs+'px;height:'+cs+'px;"><v:fill color="#ffffff" opacity="0.75" /></v:shape>';
						strok = '<v:shape strokeweight="1.5" filled="f" stroked="t" strokecolor="#808080" opacity="0" coordorigin="0,0" coordsize="'+cs+','+cs+'" path="m 0,0 c '+(ir-1)+','+vs+','+(or-1)+','+hs+','+(or-1)+','+(cs-or-1)+' qy 1,'+(cs-1)+' m '+(cs-1)+',1 qy '+(cs-or-1)+','+(or-1)+' c '+hs+','+(or-1)+','+vs+','+(ir-1)+',0,0 e" style="position:absolute;top:'+(ih-cs)+'px;left:'+(iw-cs)+'px;width:'+cs+'px;height:'+cs+'px;"></v:shape>';
					}
					shade = '<v:shape strokeweight="0" filled="t" stroked="f" fillcolor="#000000" coordorigin="0,0" coordsize="'+cs+','+cs+'" path="m 0,0 c '+ir+','+vs+','+or+','+hs+','+or+','+(cs-or)+' qy 0,'+cs+' c '+yr+','+cs+','+yr+','+cs+','+xr+','+(cs-vr)+' l '+(cs-vr)+','+xr+' c '+cs+','+yr+','+cs+','+yr+','+cs+',0 qy '+(cs-or)+','+or+' c '+hs+','+or+','+vs+','+ir+',0,0 x e" style="position:absolute;top:'+(ih-cs)+'px;left:'+(iw-cs)+'px;width:'+cs+'px;height:'+cs+'px;"><v:fill method="linear sigma" type="gradient" focus="-0.15" angle="45" color="#000000" opacity="1" color2="#000000" o:opacity2="0" /></v:shape>';
					foot = '</v:group>';
					canvas.innerHTML = head+shadow+back+fill+shine+shade+strok+foot;
					if(typeof window[callback]==='function') {window[callback](canvas.id,'cvi_curl');}
				}
			}else {
				if(canvas.tagName.toUpperCase() == "CANVAS" && canvas.getContext("2d")) {
					var context = canvas.getContext("2d"), prepared=(context.getImageData?true:false), alternate=false;
					var img = new Image();
					img.onload = function() {
						if(prepared&&(typeof cvi_filter!='undefined')&&filter!=null&&filter.length>0) {iw=Math.round(iw); ih=Math.round(ih);
							var source=document.createElement('canvas'); source.height=ih+4; source.width=iw+4; var src=source.getContext("2d");
							var buffer=document.createElement('canvas'); buffer.height=ih; buffer.width=iw; var ctx=buffer.getContext("2d");
							if(src&&ctx) {alternate=true; ctx.clearRect(0,0,iw,ih); ctx.drawImage(img,0,0,iw,ih); 
								src.clearRect(0,0,iw+4,ih+4); src.drawImage(img,0,0,iw+4,ih+4); src.drawImage(img,2,2,iw,ih); 
								for(var i in filter) {cvi_filter.add(source,buffer,filter[i],iw,ih);}
							}
						}
						context.clearRect(0,0,iw,ih);
						context.save();
						if(!invert) {
							clipCurl(context,iw-cs,ih-cs,iw,ih,or,ir);
							context.clip();
							if(!isNaN(icolor)) {
								context.fillStyle = 'rgba(0,0,0,0)';
								context.fillRect(0,0,iw,ih);
								context.rotate(dg);
								context.scale(-1,1);
								context.translate(-(iw),-(ih));
								if(alternate) {
									context.drawImage(source,2,2,iw,ih,-(ih-cs),-(iw-cs),iw,ih);
								}else {
									context.drawImage(img,-(ih-cs),-(iw-cs),iw,ih);
								}
							}
						}else {
							clipInversCurl(context,iw-cs,ih-cs,iw,ih,or,ir);
							context.clip();
							context.clearRect(0,0,iw,ih);
							if(alternate) {
								context.drawImage(source,2,2,iw,ih,0,0,iw,ih);
							}else {
								context.drawImage(img,0,0,iw,ih);
							}
						}
						context.restore();
						clipCurl(context,iw-cs,ih-cs,iw,ih,or,ir);
						context.fillStyle = 'rgba(254,254,254,0.5)';
						if(isNaN(icolor)) context.fillStyle = icolor;
						context.fill();
						clipCurl(context,iw-cs,ih-cs,iw,ih,or,ir);
						context.strokeStyle = 'rgba(128,128,128,0.5)';
						context.stroke();
						clipCurl(context,iw-cs,ih-cs,iw,ih,or,ir);
						st = context.createLinearGradient(iw-cs,ih-cs,iw-(cs*.455),ih-(cs*.455)); st.addColorStop(0,'rgba(254,254,254,0.5)'); st.addColorStop(0.33,'rgba(254,254,254,0)'); st.addColorStop(0.33,'rgba(0,0,0,0)'); st.addColorStop(0.4,'rgba(0,0,0,0.05)'); st.addColorStop(0.5,'rgba(0,0,0,0.1)'); st.addColorStop(0.75,'rgba(0,0,0,0.15)'); st.addColorStop(0.85,'rgba(0,0,0,0.3)'); st.addColorStop(0.99,'rgba(0,0,0,0.7)'); st.addColorStop(1,'rgba(0,0,0,0.8)');
						context.fillStyle = st;
						context.fill();
						context.save();
						if(!invert) {
							clipReversCurl(context,iw-cs,ih-cs,iw,ih,or,ir);
							context.clip();
							context.clearRect(0,0,iw,ih);
							if(alternate) {
								context.drawImage(source,2,2,iw,ih,0,0,iw,ih);
							}else {
								context.drawImage(img,0,0,iw,ih);
							}
							context.restore();
						}
						context.save();
						clipCurlShadow(context,iw-cs,ih-cs,iw,ih,or,ir);
						context.clip();
						context.translate(iw,ih-cs);
						context.rotate((Math.PI/180)*45);
						context.scale(0.75,1);
						curlShadow(context,cs,or,hr,ishadow);
						context.restore();
						if(typeof window[callback]==='function') {window[callback](canvas.id,'cvi_curl');}
					}
					img.src = canvas.source;
				}
			}
		} catch (e) {
		}
	},

	replace : function(canvas) {
		var object = canvas.parentNode; 
		var img = document.createElement('img');
		img.id = canvas.id;
		img.alt = canvas.alt;
		img.title = canvas.title;
		img.src = canvas.source;
		img.height = canvas.height;
		img.width = canvas.width;
		img.className = canvas.className;
		img.style.cssText = canvas.style.cssText;
		img.style.height = canvas.height+'px';
		img.style.width = canvas.width+'px';
		object.replaceChild(img,canvas);
	},

	remove : function(canvas) {
		if(document.all&&document.namespaces&&!window.opera&&(!document.documentMode||document.documentMode<9)) {
			if(canvas.tagName.toUpperCase() == "VAR") {
				cvi_curl.replace(canvas);
			}
		}else {
			if(canvas.tagName.toUpperCase() == "CANVAS") {
				cvi_curl.replace(canvas);
			}
		}
	}
}