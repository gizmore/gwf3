<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: Warchall - 7 Tropical Fruits');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 8, 'challenge/warchall/tropical/7/index.php');
}
$chall->showHeader();
$chall->onCheckSolution();

echo GWF_Box::box($chall->lang('info', array('/challenge/warchall/begins/index.php'), $chall->lang('title')));

formSolutionbox($chall, 18);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>