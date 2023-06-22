<?php
$solution = @include 'solution.php';
$solution = $solution ?: null;
$ds = DIRECTORY_SEPARATOR;
$challdir = getcwd() . $ds;
$i = strpos($challdir, "{$ds}challenge{$ds}");
$d = substr($challdir, 0, $i);
chdir($d);
define('NO_HEADER_PLEASE', true);
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/WC_CodegeexChallenge.php');
$cgx = WC_CodegeexChallenge::byCWD($challdir);
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$chall = $cgx->getChallenge();
$title = $chall->getTitle();
require_once("challenge/html_head.php");
echo $gwf->onDisplayHead();# . '<div id="page_wrap">';
$score = $cgx->getScore();
// $solution = false;
$url = $cgx->getChallenge()->getVar('chall_url');
$creators = "gizmore,x";
$tags = 'Training,CGX,Exploit,MySQL';
$verbose = true;
$options = 0;
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose, $options);

require_once("challenge/html_foot.php");
