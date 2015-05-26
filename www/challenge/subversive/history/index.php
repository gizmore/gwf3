<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Repeating History');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/subversive/history/index.php', false);
}
$chall->showHeader();
$chall->onCheckSolution();
$url1 = 'https://www.wechall.net/challenge';
$url2 = 'https://github.com/gizmore/gwf3';
$url3 = '/profile/kwisatz';
echo GWF_Box::box($chall->lang('info', array($url1, $url2, $url3)), $chall->lang('title'));
formSolutionbox($chall, 14);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
