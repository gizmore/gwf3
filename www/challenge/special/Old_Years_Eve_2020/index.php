<?php
$solution = require 'password.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'Old Years Eve 2020');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 5, 'challenge/special/Old_Years_Eve_2020/index.php', $solution);
}
$chall->showHeader();

$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$username = $user->displayUsername();

echo "<!-- BEGIN OF CHALLENGE -->\n";
echo GWF_Box::box($chall->lang('info', [$username]), $chall->lang('title'));
echo "<!-- END OF CHALLENGE -->\n";

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
