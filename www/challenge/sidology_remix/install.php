<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install Sidology");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Sidology Remix";
$solution = false;
$score = 5;
$url = "challenge/sidology_remix/index.php";
$creators = "Gizmore";

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>