<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Warchall: Tryouts');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 5, 'challenge/warchall/tryouts/index.php');
}
$chall->showHeader();
$chall->onCheckSolution();

$matrixman = '<a href="/profile/matrixman">matrixman</a>';
$home = '<i>/home/level/matrixman/13_tryouts</i>';
$war_url = GWF_WEB_ROOT.'challenge/warchall/begins/index.php';
echo GWF_Box::box($chall->lang('info', array($matrixman, $home, $war_url)), $chall->lang('title'));

formSolutionbox($chall, 14);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
