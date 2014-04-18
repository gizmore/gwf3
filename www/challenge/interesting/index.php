<?php
$solutions = require('solution.php');
chdir('../../');
define('GWF_PAGE_TITLE', 'Interesting');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/interesting/index.php', false);
}
$chall->showHeader();
if (isset($_POST['answer']) && is_string($_POST['answer']))
{
	$_POST['answer'] = preg_replace('/[^a-z]/', '', strtolower($_POST['answer']));
}
$chall->onCheckSolution();
$href = GWF_WEB_ROOT.'places';
$bunny = sprintf('<a href="%s/profile/EasterBunny">%s</a>', GWF_WEB_ROOT, $chall->lang('bunny'));
echo GWF_Box::box($chall->lang('info', array($href, count($solutions), $bunny)), $chall->lang('title'));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
