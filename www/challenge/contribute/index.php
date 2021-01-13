<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Contribute');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/contribute/index.php', false);
}
$chall->showHeader();

$user = GWF_User::getStaticOrGuest();
$username = $user->displayUsername();
$url = 'https://github.com/gizmore/gdo6';

echo GWF_Box::box($chall->lang('info', [$username, $url]), $chall->lang('title'));

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
