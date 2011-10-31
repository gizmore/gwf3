<?php
chdir("../../");
require_once("html_head.php");
html_head("Install Trivia Challenge");

if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Trivia";
$solution = false;
$score = 4;
$url = "challenge/trivia/index.php";
$creators = "Z,Gizmore";
$tags = 'Fun';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("html_foot.php");
?>
