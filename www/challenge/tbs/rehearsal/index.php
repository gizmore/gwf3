<?php
$solution = require 'secret.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "TBS Rehearsal");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/tbs/rehearsal/index.php', $solution);
}

$chall->showHeader();

$chall->onCheckSolution();
$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$linkA = sprintf('<a href="%sdownloads">%s</a>', GWF_WEB_ROOT, $chall->lang('link_one'));
$yt = 'https://www.youtube.com/watch?v=2SZ86fI3CLU';
$linkB = sprintf('<a href="%s">%s</a>', $yt, $chall->lang('link_two'));
$info = $chall->lang('info', array($name, $linkA, $linkB));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
