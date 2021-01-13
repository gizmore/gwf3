<?php
$password = require 'password.php';

chdir('../../');
define('GWF_PAGE_TITLE', 'Memorized');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 7, 'challenge/memorized/index.php', $password);
}
$chall->showHeader();

$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$username = $user->displayUsername();
$url = 'https://ranzgruppe.com';

echo GWF_Box::box($chall->lang('info', [$username, $url]), $chall->lang('title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
