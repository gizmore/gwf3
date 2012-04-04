<?php
chdir("../../../");
require_once("challenge/html_head.php");
html_head("Install Z - Reloaded");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Z - Reloaded";
$solution = false;
$score = 6;
$url = "challenge/Z/reloaded/index.php";
$creators = "Z,Gizmore";
$tags = '';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
