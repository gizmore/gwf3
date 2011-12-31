<?php
chdir("../../../");
require_once("challenge/html_head.php");

if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Training: Stegano I";
$solution = "steganoI";
$score = 1;
$url = "challenge/training/stegano1/index.php";
$creators = "Gizmore";
$tags = 'Stegano';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");

?>
