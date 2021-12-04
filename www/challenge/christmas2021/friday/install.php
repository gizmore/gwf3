<?php
chdir("../../../");
require_once("challenge/html_head.php");
$title = '2021 Christmas Friday';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 3;
$url = "challenge/christmas2021/friday/index.php";
$creators = "gizmore";
$tags = 'Coding';
$verbose = true;

GWF_ForumBoard::init(false, true);
WC_Challenge::installChallenge($title, false, $score, $url, $creators, $tags, $verbose, WC_Challenge::CHALL_CASE_S);

require_once("challenge/html_foot.php");
