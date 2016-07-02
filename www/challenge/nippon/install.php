<?php
$solution = require 'solution.php';
chdir('../../');
require_once("challenge/html_head.php");
$title = 'Nippon';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 3;
$url = "challenge/nippon/index.php";
$creators = "gizmore";
$tags = 'Stegano,Crypto';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_S);

require_once("challenge/html_foot.php");
