<?php
chdir("../../../");
require_once("challenge/html_head.php");
$title = '2021 Christmas Gifts';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$score = 4;
$url = "challenge/christmas2021/gifts/index.php";
$creators = "gizmore";
$tags = 'Coding';
$verbose = true;
$solution = false;

GWF_ForumBoard::init(false, true);
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose);

require_once("challenge/html_foot.php");
