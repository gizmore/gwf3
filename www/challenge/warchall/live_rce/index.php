<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Warchall: Live RCE');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/warchall/live_rce/index.php');
}
$chall->showHeader();
$chall->onCheckSolution();

$home = 'http://rce.warchall.net';
$war_url = GWF_WEB_ROOT.'challenge/warchall/begins/index.php';
echo GWF_Box::box($chall->lang('info', array($home, $war_url)), $chall->lang('title'));

formSolutionbox($chall, 14);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
