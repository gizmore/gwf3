<!DOCTYPE html>
<html>
<head>
<title>IT Multiservice Busch</title>
<style type="text/css">
* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	text-align: left;
}

#pagewrap div {
	padding: 2em;
}

#pagewrap #header {
	float: none;
}

#firstrow {
	position: relative;
	height: 22em;
	width: 100%;
}

#firstrow object {
	width: 100%;
/* 	width: 225px; */
	height: auto;
	zoom: auto;
}

#top-logo {
	margin: 0.5em;
	width: 20em!important;
	height: 20em!important;
	float: left;
}

#header span {
	padding-left: 1em;
}

#footer {
	position: relative;
	bottom: 0px;
	background: #f00;
	height: 22em;
	width: 100%;
}

.itmb-hr {
	background: transparent;
	height: 0.6em;
}

#footer span, #header span {
	font-size: 2.14em;
	display: block;
}

#main-content {
	min-height: 24em;
	font-family: monospace;
	font-size: 2.4em;
}

gsvg::first-letter{
  border: 0; 
  font: 0/0 a; 
  text-shadow: none; 
  color: transparent;
}
 
gsvg span.logo{
  display:inline-block;
  float:left;
  width: 160px;
  height:160px;
  margin: 0.7em; 
  background-image: url("itmb_logo_full.svg");
  background-repeat: no-repeat;
  background-size: contain;
}
</style>
</head>
<body>

<pre>
<?php
$translation = array(
	'de' => array(
		'main_content' => 'Preise nur nach Vereinbarung im Bereich von 10-80 Euro.<br/>Ich mag auch Werbeartikel.',
	),
	'en' => array(
		'main_content' => 'Prices vary in ranges of $10 to $80.<br/>I also like beerware.',
	),
	'es' => array(
		'main_content' => 'Ona Hora des servizia les muy es 10 – 80 Euro.',
	),
	'fr' => array(
		'main_content' => 'Un\our des Servizia dé moi eset 10 - 80 Euro.',
	),
);
$locales = array_keys($translation);
$locale = $locales[array_rand($locales, 1)];
$t = $translation[$locale];
?>
</pre>


<script type="text/javascript">
window.ITMB = {
	locale: '<?php echo $locale; ?>',
	svg_loaded: function(svg) {
	},
}

</script>
	<div id="pagewrap">
		<div id="firstrow">
			<gsvg><span>g</span></gsvg>
			<div id="header">
				<span>Programming, Consulting, Architecture, Support</span>
				<div class="itmb-hr"></div>
				<span>+49 176 59 59 88 44</span>
			</div>
		</div>
		<div id="main-content">
			<?= sprintf($t['main_content']); ?>
		</div>
		<div id="footer">
			<span>IT Multiservice Busch</span><span>StId: TBD0000000000000</span>
			<div class="itmb-hr"></div>
			<span>Christian Busch</span><span>Am Bauhof 15</span><span>31224 Peine</span><span>Germany</span>
		</div>
	</div>
</body>
</html>