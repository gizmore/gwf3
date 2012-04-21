<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install WC Hashing Game");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$title = 'WC Hashing Game';
$solution = false;
$score = 5;
$url = "challenge/hashgame/index.php";
$creators = "Gizmore";
$tags = 'Cracking';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
