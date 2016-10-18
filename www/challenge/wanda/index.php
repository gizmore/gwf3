<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Wanda');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/wanda/index.php', 'E1C2C91B0C1AFCF97FCFF0EFE148D5C8');
}
if (isset($_POST['answer']))
{
	$_POST['answer'] = strtoupper(md5($_POST['answer']));
}
$chall->showHeader();
$chall->onCheckSolution();
$href = 'https://wanda.gizmore.org';
echo GWF_Box::box($chall->lang('info', array($href)), $chall->lang('title').' – '.$chall->lang('subtitle'));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
