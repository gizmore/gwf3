<?php
$secret = require 'secret.php';
chdir('../../');
define('GWF_PAGE_TITLE', "Valentine's Gold");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/valentines_gold/index.php', $secret);
}
$chall->showHeader();
$chall->onCheckSolution();
$user = GWF_User::getStaticOrGuest();
$name1 = $user->isGuest() ? 'tehron' : $user->displayUsername();
$name2 = $user->isGuest() ? 'hacker' : $user->displayUsername();
$info = $chall->lang('info', array($name1, $name2));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
