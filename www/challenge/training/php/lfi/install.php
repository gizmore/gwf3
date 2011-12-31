<?php
chdir("../../../../");
require_once("challenge/html_head.php");
html_head("Install Training: PHP LFI");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::error('WeChall', 'This script would install this challenge. It`s not of interest for you.');
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}


$title = 'Training: PHP LFI';
$solution = false;
$score = 2;
$url = "challenge/training/php/lfi/up/index.php";
$creators = "Gizmore";
$tags = 'Exploit,PHP,Training';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
