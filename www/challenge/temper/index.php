<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Temper');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 6, 'challenge/temper/index.php', false);
}
$chall->showHeader();

$user = GWF_User::getStaticOrGuest();
$username = $user->displayUsername();
$login = 'site/login.php';
$github = 'https://github.com/gizmore/gwf3';

echo GWF_Box::box($chall->lang('info', [$username, $login, $github]), $chall->lang('title'));

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
