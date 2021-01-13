<?php
chdir("../../");
require_once("challenge/html_head.php");
$title = 'Contribute';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 3;
$url = "challenge/contribute/index.php";
$creators = "gizmore";
$tags = 'Special';
$solution = false;

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_I);

require_once("challenge/html_foot.php");
