<?php

header('Content-type: text/css');

if(!isset($_GET['color'])) {
	$_GET['color'] = 'orange';
}

switch($_GET['color']) {
	case 'blue': 
		$color = array(
			'base_color' => 'blue',
			'design_dark' => '#076df3',
			'design_light' => '#00a3f9',
			'border_dark' => '#076df3',
			'border_light' => '#00a3f9',
		);
	break;
	case 'green':
		$color = array(
			'base_color' => 'green',
			'design_dark' => '#006400',
			'design_light' => '#00FF00',
			'border_dark' => '#006400',
			'border_light' => '#00FF00',
	);
	break;
	case 'orange':
		$color = array(
			'base_color' => 'orange',
			'design_dark' => '#FF8C00',
			'design_light' => '#FFA500',
			'border_dark' => '#FF8C00',
			'border_light' => '#FFA500',
	);
	break;
	case 'red':
		$color = array(
			'base_color' => 'red',
			'border_light' => '#a33a3a',
			'border_dark' => '#8e0a0a',
			'design_light' => '#FF0000',
			'design_dark' => '#8B0000',
	);
	break;
	case 'yellow':
		$color = array(
			'base_color' => 'yellow',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
	);
	break;
	case 'purple':
		$color = array(
			'base_color' => 'purple',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
	);
	break;
	case 'white':
		$color = array(
			'base_color' => 'white',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
	);
	break;
	case 'black':
		$color = array(
			'base_color' => 'black',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
	);
	break;
	case 'brown':
		$color = array(
			'base_color' => 'brown',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
	);
	break;
	default:
		$color = array(
			'base_color' => 'orange',
			'design_dark' => '#FF8C00',
			'design_light' => '#FFA500',
			'border_dark' => '#FF8C00',
			'border_light' => '#FFA500',
	);
	break;
}

$tpl = array(
	'design' => 'SF/',
	'layout' => 'space',
);

?>

.top {
	background-image:url('templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/contenthead.png');
}

/*- ------------------------ MAIN THINGS AND ID's ------------------------*/
div#margin { /* BORDER HIGHLIGHT EFECT*/
	background-color: <?php echo $color['border_light']; ?>;
	border: thin solid <?php echo $color['border_dark']; ?>;
}
div#logo {
	background: #131313 url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/header.png') no-repeat center right; 
	border-top: thin groove <?php echo $color['design_dark']; ?>;
}
/*div#footer*/
div#profil,
div#body
{
	border-top: thin groove <?php echo $color['design_dark']; ?>;
}

.navigation hr,
#inhalt hr,
textarea,
input,
div.sitenav { 
	background-color: <?php echo $color['design_dark']; ?>; 
}
/*p.bottom,
p.top,*/
#sitenav a:hover span,
fieldset legend {
	border: thin solid <?php echo $color['design_light']; ?>;
}
fieldset
{
	background:transparent url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/trans.png');
}

/* ------------------------------ LAYOUT ---------------------------- */
.color,
#inhalt p:first-letter {
	color: <?php echo $color['design_dark']; ?>; 
}
a.backbutton,
div#profil a,
div#copyright a,
div#details a,
div#footer,
.inhalt a,
.inhalt a:visited,
.inhalt a:active,
.inhalt a:hover,
.navigation a:hover {
	color: <?php echo $color['design_light']; ?>;
}

hr {
	border-bottom: thin solid <?php echo $color['design_dark']; ?>;
}

/*--------------------------- HEADNAV -------------------------------*/
ol.navi h2 > a:first-letter,
div#headnavi > ol.navi > li.sec > ul > li:hover > a,
div#headnavi > ol.navi > li.sec > ul > li > ul li:hover > a,
div#headnavi * a:hover,
div#headnavi > ol.navi > li.sec > h2 > a:first-letter,
div#headnavi > ol.navi > li.sec > h2:hover { 
	color: <?php echo $color['design_dark']; ?> !important; 
}

div#headnavi > ol.navi > li > ul,
div#headnavi > ol.navi > li > ul > li > ul {
	border: thin solid <?php echo $color['design_dark']; ?>;
}
div#headnavi > ol.navi > li > ul > li.sub:after {
	background-color: <?php echo $color['border_light']; ?>;
}
div#headnavi > ol.navi > li > ul > li > ul > li {
	border-top: thin solid <?php echo $color['design_light']; ?>;
	border-bottom: thin solid <?php echo $color['design_dark']; ?>;
	border-left: thin solid #1c1c1c;
	border-right: thin solid #131313;
}
div#headnavi > ol.navi > li > ul > li.sub:hover:after { 
	background-color: <?php echo $color['design_dark']; ?>; 
}

/*--------------------------- NAVIGATION ---------------------------*/

div.navigation li.subcat_link,
div.navigation li.sec_link,
div.navigation li.cat_link { 
	list-style-image:url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/round.png'); 
}
div.navigation li.subcat_link:hover,
div.navigation li.sec_link:hover,
div.navigation li.cat_link:hover { 
	list-style-image:url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/navi.png'); 
}
div.navigation li.cat, div.navigation li.subcat {
	list-style-image:url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/navi.png'); 
}
div.navigation li.cat:hover, div.navigation li.subcat:hover { 
	list-style-image:url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/down.png'); 
}
div.navigation li.subcat:hover > ul {
	list-style-image:url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/down.png'); 
}
/*
div.navigation > ol.navi > li.sec > ul > li.cat > ul > li:hover:before {
	content: url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/navi.png');
}
*/
div.navigation > ol.navi > li.sec > ul > li.cat:hover { list-style-image:url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/down.png'); }

div.navigation > ol.navi > li.sec > ul > li.cat > ul > li { list-style-image:url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/round.png'); }

div.navigation > ol.navi > li.sec > ul > li.cat > ul > li:hover,
div.navigation > ol.navi > li.sec > ul > li.cat { list-style-image: url('/templates/<?php echo $tpl['design'] . $tpl['layout']; ?>/images/<?php echo $color['base_color']; ?>/navi.png'); }

div.navigation > ol.navi > li.sec > ul > li.cat:target > ul {
	border: thin solid <?php echo $color['design_dark']; ?>;
	border-right: thin solid <?php echo $color['design_light']; ?>;
}
div.navigation > ol.navi > li.sec > ul > li.cat:target {
	background-color: <?php echo $color['design_light']; ?>; 
}
div.navigation > ol.navi > li.sec > ul > li.cat:hover > ul {
	border: thin solid <?php echo $color['design_light']; ?>;
	border-right: thin solid <?php echo $color['design_dark']; ?>;
}

div.navigation > ol.navi > li.sec > ul > li.cat:hover { 
	background-color: <?php echo $color['design_dark']; ?>; 
}
