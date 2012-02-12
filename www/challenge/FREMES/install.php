<?php
chdir("../../");
require_once("challenge/html_head.php");
$title = 'Fremes';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 4;
$url = "challenge/FREMES/index.php";
$creators = "Gizmore";
$tags = 'Stegano';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
