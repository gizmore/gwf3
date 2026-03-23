<?php
$solution = require_once 'solution.php';
chdir("../../../");
require_once("challenge/html_head.php");
define('GWF_PAGE_TITLE', 'Choose your Path III');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin!");
}

$score = 2;
$url = 'challenge/warchall/choose_your_path3/index.php';
$creators = "cyp";
$tags = 'Warchall,Exploit';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");

