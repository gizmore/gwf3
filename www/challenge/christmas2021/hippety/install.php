<?php
$solution = require 'solution.php';
chdir("../../../");
require_once("challenge/html_head.php");
$title = '2021 Christmas Hippety';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 1;
$url = "challenge/christmas2021/hippety/index.php";
$creators = "gizmore";
$tags = 'Stegano';
$verbose = true;

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose, WC_Challenge::CHALL_CASE_S);

require_once("challenge/html_foot.php");
