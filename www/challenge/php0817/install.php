<?php
chdir('../../');
require_once('challenge/html_head.php');
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}

$title = "PHP 0817";
$solution = false;
$score = 2;
$url = "challenge/php0817/index.php";
$creators = "Gizmore";
$tags = 'PHP,Exploit';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
