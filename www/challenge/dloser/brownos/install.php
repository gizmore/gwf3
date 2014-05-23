<?php
$solution = require 'solution.php';
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'The BrownOS';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 7;
$url = "challenge/dloser/brownos/index.php";
$creators = "dloser";
$tags = 'Unknown';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_I);

require_once("challenge/html_foot.php");
