<?php
$solution = require 'password.php';
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'Old Years Eve 2020';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 7;
$url = "challenge/special/Old_Years_Eve_2020/index.php";
$creators = "Dr_Blutig";
$tags = 'Special,Crypto';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_I);

require_once("challenge/html_foot.php");
