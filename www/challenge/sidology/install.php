<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install Sidology");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Sidology";
$solution = false;
$score = 5;
$url = "challenge/sidology/index.php";
$creators = "Gizmore";

htmlDisplayError(ChallengeTable::addChallenge($title, $solution, $score, $url, $creators));

require_once("challenge/html_foot.php");
?>