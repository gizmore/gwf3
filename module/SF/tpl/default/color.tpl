.top {ldelim}
	background-image:url('/templates/{$tpl['design']}{$tpl['layout']}/images/contenthead.png');
{rdelim}

/*- ------------------------ MAIN THINGS AND ID's ------------------------*/
div#margin {ldelim} /* BORDER HIGHLIGHT EFECT*/
	background-color: {$color['border_light']};
	border: thin solid {$color['border_dark']};
{rdelim}
div#logo {ldelim}
	background: #131313 url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/header.png') no-repeat center right; 
	border-top: thin groove {$color['design_dark']};
{rdelim}
/*div#footer*/
div#profile,
div#body {ldelim}
	border-top: thin groove {$color['design_dark']};
{rdelim}

.navigation hr,
#inhalt hr,
textarea,
input,
div.sitenav {ldelim} 
	background-color: {$color['design_dark']}; 
{rdelim}
/*p.bottom,
p.top,*/
#sitenav a:hover span,
fieldset,
fieldset legend {ldelim}
	border: thin solid {$color['design_light']};
{rdelim}
fieldset
{ldelim}
	background:transparent url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/trans.png');
{rdelim}

/* ------------------------------ LAYOUT ---------------------------- */
.color,
#inhalt p:first-letter {ldelim}
	color: {$color['design_dark']}; 
{rdelim}
a,
a.backbutton,
div#profile a,
div#copyright a,
div#details a,
div#footer,
.inhalt a,
.inhalt a:visited,
.inhalt a:active,
.inhalt a:hover,
.navigation a:hover {ldelim}
	color: {$color['design_light']};
{rdelim}

hr {ldelim}
	border-bottom: thin solid {$color['design_dark']};
{rdelim}

/*--------------------------- HEADNAV -------------------------------*/
ol.navi h2 > a:first-letter,
div#headnavi > ol.navi > li.sec > ul > li:hover > a,
div#headnavi > ol.navi > li.sec > ul > li > ul li:hover > a,
div#headnavi * a:hover,
div#headnavi > ol.navi > li.sec > h2 > a:first-letter,
div#headnavi > ol.navi > li.sec > h2:hover {ldelim} 
	color: {$color['design_dark']} !important; 
{rdelim}

div#headnavi > ol.navi > li > ul,
div#headnavi > ol.navi > li > ul > li > ul {ldelim}
	border: thin solid {$color['design_dark']};
{rdelim}
div#headnavi > ol.navi > li > ul > li.sub:after {ldelim}
	background-color: {$color['border_light']};
{rdelim}
div#headnavi > ol.navi > li > ul > li > ul > li {ldelim}
	border-top: thin solid {$color['design_light']};
	border-bottom: thin solid {$color['design_dark']};
	border-left: thin solid #1c1c1c;
	border-right: thin solid #131313;
{rdelim}
div#headnavi > ol.navi > li > ul > li.sub:hover:after {ldelim} 
	background-color: {$color['design_dark']}; 
{rdelim}

/*--------------------------- NAVIGATION ---------------------------*/

div.navigation li.subcat_link,
div.navigation li.sec_link,
div.navigation li.cat_link {ldelim} 
	list-style-image:url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/round.png'); 
{rdelim}
div.navigation li.subcat_link:hover,
div.navigation li.sec_link:hover,
div.navigation li.cat_link:hover {ldelim} 
	list-style-image:url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/navi.png'); 
{rdelim}
div.navigation li.cat, div.navigation li.subcat {ldelim}
	list-style-image:url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/navi.png'); 
{rdelim}
div.navigation li.cat:hover, div.navigation li.subcat:hover {ldelim} 
	list-style-image:url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/down.png'); 
{rdelim}
div.navigation li.subcat:hover > ul {ldelim}
	list-style-image:url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/down.png'); 
{rdelim}
/*
div.navigation > ol.navi > li.sec > ul > li.cat > ul > li:hover:before {ldelim}
	content: url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/navi.png');
{rdelim}
*/
div.navigation > ol.navi > li.sec > ul > li.cat:hover {ldelim} list-style-image:url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/down.png');
{rdelim}

div.navigation > ol.navi > li.sec > ul > li.cat > ul > li {ldelim} list-style-image:url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/round.png');
{rdelim}

div.navigation > ol.navi > li.sec > ul > li.cat > ul > li:hover,
div.navigation > ol.navi > li.sec > ul > li.cat {ldelim} list-style-image: url('/templates/{$tpl['design']}{$tpl['layout']}/images/{$color['base_color']}/navi.png');
{rdelim}

div.navigation > ol.navi > li.sec > ul > li.cat:target > ul {ldelim}
	border: thin solid {$color['design_dark']};
	border-right: thin solid {$color['design_light']};
{rdelim}
div.navigation > ol.navi > li.sec > ul > li.cat:target {ldelim}
	background-color: {$color['design_light']}; 
{rdelim}
div.navigation > ol.navi > li.sec > ul > li.cat:hover > ul {ldelim}
	border: thin solid {$color['design_light']};
	border-right: thin solid {$color['design_dark']};
{rdelim}

div.navigation > ol.navi > li.sec > ul > li.cat:hover {ldelim} 
	background-color: {$color['design_dark']}; 
{rdelim}
