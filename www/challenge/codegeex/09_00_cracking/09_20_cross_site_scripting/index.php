<?php
$ds = DIRECTORY_SEPARATOR;
$challdir = getcwd() . $ds;
$i = strpos($challdir, "{$ds}challenge{$ds}");
$d = substr($challdir, 0, $i);
chdir($d);
define('NO_HEADER_PLEASE', true);
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/WC_CodegeexChallenge.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
$cgx = WC_CodegeexChallenge::byCWD($challdir);
$prob = $cgx->hasProblem();
$user = GWF_User::getStaticOrGuest();
$chall = $cgx->getChallenge();
define('GWF_PAGE_TITLE', $chall->getTitle());
/** @var $gwf GWF3 **/
echo $gwf->onDisplayHead();

include 'mask1.code';

$chall->onCheckSolution();

$chall->showHeader();

echo $cgx->getInfoBox();

if ($cgx->hasVideo())
{
	echo $cgx->getVideoBoxes();
}

require "mask1.code";


	formSolutionbox($chall);

echo $cgx->getDraftBox();

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
