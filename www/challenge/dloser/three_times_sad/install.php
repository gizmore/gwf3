<?php
$solution = require 'solution.php';
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'Three Times Sad';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 5;
$url = "challenge/dloser/three_times_sad/index.php";
$creators = "dloser";
$tags = 'Crypto';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_I);

require_once("challenge/html_foot.php");
