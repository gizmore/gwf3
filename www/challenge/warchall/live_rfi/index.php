<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Warchall: Live RFI');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/warchall/live_rfi/index.php');
}
$chall->showHeader();
$chall->onCheckSolution();

$home = 'http://rfi.warchall.net';
$war_url = GWF_WEB_ROOT.'challenge/warchall/begins/index.php';
echo GWF_Box::box($chall->lang('info', array($home, $war_url)), $chall->lang('title'));

formSolutionbox($chall, 14);
echo $chall->copyrightFooter();
require 'challenge/warchall/ads.php';
require_once('challenge/html_foot.php');
