<?php
chdir('../../../');
require_once("challenge/html_head.php");
$title = 'Stalking';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("If you don´t know me by now! You will never never know me!");
}
$solution = false;
$score = 10;
$url = "challenge/identity/stalking/index.php";
$creators = "gizmore";
$tags = 'Realistic,Research';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
