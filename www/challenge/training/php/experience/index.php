<?php
$data = require('data.php');
$solution = require('solution.php');
require 'expdb.php';
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Experience');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/training/php/experience/index.php', $solution);
}
$chall->showHeader();
$chall->onCheckSolution();

$user = GWF_User::getStaticOrGuest();
$username = $user->isGuest() ? $chall->lang('guest') : $user->displayUsername();
$hint = '<span style="color:#fff;">'.$chall->lang('hint').'</span>'.PHP_EOL;
echo GWF_Box::box($chall->lang('descr', array($username, $hint)));

if (!($db = gdo_db_instance(EXP_DB_HOST, EXP_DB_USER, EXP_DB_PASS, EXP_DB_NAME)))
{
	echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
}
else
{
	require 'blackbox.php';
	formSolutionbox($chall);
}
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
