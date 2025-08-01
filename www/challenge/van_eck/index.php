<?php
list($n, $solution) = require('solution.php');
chdir('../../');
define('GWF_PAGE_TITLE', "Van Eck");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/van_eck/index.php', $solution);
}
$chall->showHeader();
$chall->onCheckSolution();
$user = GWF_User::getStaticOrGuest();
$yt = 'https://www.youtube.com/watch?v=etMJxB-igrc';
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$info = $chall->lang('info', array($name, $n, $yt));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
