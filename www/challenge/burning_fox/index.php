<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Burning Fox');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/burning_fox/index.php', false);
}
$chall->showHeader();
$chall->onCheckSolution();
echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));
formSolutionbox($chall, 14);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>