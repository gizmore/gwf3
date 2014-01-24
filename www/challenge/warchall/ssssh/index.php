<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'SSH... Z is sleeping');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/warchall/ssssh/index.php', false);
}
$chall->showHeader();

$chall->onCheckSolution();

$href_warchall = GWF_WEB_ROOT.'challenge/warchall/begins';
echo GWF_Box::box($chall->lang('info', array($href_warchall)), $chall->lang('title'));
formSolutionbox($chall, 14);

echo $chall->copyrightFooter();
require 'challenge/warchall/ads.php';
require_once('challenge/html_foot.php');
