<?php
/** @var $chall WC_Challenge **/
$wc = GWF_WEB_ROOT . 'challenge/codegeex/';
$linkWC = sprintf('<a href="%s">%s</a>', $wc, $chall->lang('on_wc'));
$gh = 'https://github.com/gizmore/gwf3/tree/master/www/challenge/codegeex';
$linkGH = sprintf('<a href="%s">%s</a>', $gh, $chall->lang('on_gh'));
$yt = 'https://youtube.com/@codinggeex';
$linkYT = sprintf('<a href="%s">%s</a>', $yt, $chall->lang('on_yt'));
$linkYT2 = sprintf('<a href="%s">%s</a>', $yt, '@Codinggeex');
return $chall->lang('info', [
	$linkYT2,
	$linkWC,
	$linkGH,
	$linkYT,
]);
