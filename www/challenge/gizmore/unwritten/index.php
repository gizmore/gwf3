<?php
$secret = require 'secret.php';

chdir('../../../');
define('GWF_PAGE_TITLE', "Unwritten");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/gizmore/unwritten/index.php', $secret);
}

$chall->showHeader();

$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$info = $chall->lang('info', array('<img src="data/data.png" height="128"/>'));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
