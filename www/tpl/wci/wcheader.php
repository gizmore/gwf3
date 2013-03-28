<?php
if (WC_HTML::$HEADER === false)
{
	return;
}


$module = Module_WeChall::instance();
$logo_url = $module->cfgLogoURL();

$style = '
min-height: 140px;
display: block;
float: left;
';

echo
'<header id="wc_head">'.PHP_EOL.
#'<div class="fr">'.WC_HTML::displayHeaderLogin($module).'</div>'.PHP_EOL.
'<a href="'.$logo_url.'" style="'.$style.'" title="WeChall"><img src="/favicon.png" style="'.$style.'" /></a>'.PHP_EOL.
'<div id="wc_head_stats">'.PHP_EOL.
// WC_HTML::displayHeaderSites($module).PHP_EOL.
// WC_HTML::displayHeaderUsers($module).PHP_EOL.
WC_HTML::displayHeaderLogin($module).PHP_EOL.
WC_HTML::displayHeaderOnline($module).PHP_EOL.
'</div>'.PHP_EOL.
'</header>'.PHP_EOL.
'<div class="cb"></div>'.PHP_EOL;
