<?php
require 'secrets.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'Disclosures');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 5, 'challenge/dloser/disclosures/index.php', DLDC_SOLUTION);
}
$chall->showHeader();

$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$box_content = $chall->lang('info', array(
	($user->isGuest() ? $chall->lang('hacker') : $user->displayUsername()),
	'<a href="/profile/dloser" title="WeChall Profile of dloser">dloser</a>',
	'www/home.php',
	'www/viewer.php?f=home.php',
));
echo GWF_Box::box($box_content, $chall->lang('title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
