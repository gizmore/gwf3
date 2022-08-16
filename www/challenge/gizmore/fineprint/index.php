<?php
$solution = require 'secret.php';
chdir('../../../');
define('GWF_PAGE_TITLE', "Fineprint");
// require_once('challenge/gwf_include.php');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/gizmore/fineprint/index.php', $solution);
}
$chall->showHeader();
$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$info = $chall->lang('info', array($name, "<a href=\"https://fineprint.phpgdo.com\">GDOv7 Fineprint</a>"));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
