<?php
$solution = require 'password.php';
chdir("../../../");
require_once("challenge/html_head.php");
$title = '2020 Christmas Special';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 5;
$url = "challenge/quangntenemy/2020_Christmas_Special/index.php";
$creators = "quangntenemy,gizmore";
$tags = 'Special,Crypto,Stegano';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_S);

require_once("challenge/html_foot.php");
