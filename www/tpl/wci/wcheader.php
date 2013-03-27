<?php
if (WC_HTML::$HEADER === false)
{
	return;
}

$logo_url = GWF_WEB_ROOT.'about_wechall';

$module = Module_WeChall::instance();

echo
'<header id="wc_head">'.PHP_EOL.
#'<div class="fr">'.WC_HTML::displayHeaderLogin($module).'</div>'.PHP_EOL.
'<a href="'.$logo_url.'" id="wc_logo" title="WeChall"></a>'.PHP_EOL.
'<div id="wc_head_stats">'.PHP_EOL.
// WC_HTML::displayHeaderSites($module).PHP_EOL.
// WC_HTML::displayHeaderUsers($module).PHP_EOL.
WC_HTML::displayHeaderLogin($module).PHP_EOL.
WC_HTML::displayHeaderOnline($module).PHP_EOL.
'</div>'.PHP_EOL.
'</header>'.PHP_EOL.
'<div class="cb"></div>'.PHP_EOL;

?>