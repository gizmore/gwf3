<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Choose your Path II');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/warchall/choose_your_path2/index.php', false);
}
$chall->showHeader();
$chall->onCheckSolution();
$home = '<i>/home/level/11/</i>';
$war_url = GWF_WEB_ROOT.'challenge/warchall/begins/index.php';
echo GWF_Box::box($chall->lang('info', array($home, $war_url)), $chall->lang('title'));
formSolutionbox($chall, 14);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
