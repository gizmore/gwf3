<?php
$solution = require 'password.php';
chdir("../../");
require_once("challenge/html_head.php");
$title = 'Memorized';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 7;
$url = "challenge/memorized/index.php";
$creators = "gizmore";
$tags = 'Exploit';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_I);

require_once("challenge/html_foot.php");
