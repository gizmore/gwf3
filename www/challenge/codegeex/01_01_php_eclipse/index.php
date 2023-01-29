<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'CGX: Install Eclipse');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/coding_ala_giz/01_01_php_eclipse/index.php', false);
}
$chall->showHeader();
$url = 'allamox, please create a youtube video how to install eclipse, php, mysql, xdebug, git4windows on windows.';
echo GWF_Box::box($chall->lang('info', [$url]), $chall->lang('title'));
$user = GWF_User::getStaticOrGuest();
if (!$user->isLoggedIn())
{
	$chall->onChallengeSolved($user->getID());
}
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
