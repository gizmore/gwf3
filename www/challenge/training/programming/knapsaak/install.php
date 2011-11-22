<?php
chdir("../../../../");
require_once("html_head.php");
$title = 'The Travelling Customer';

html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 5;
$url = "challenge/training/programming/knapsaak/index.php";
$creators = "Gizmore";
$tags = 'Coding,Training';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("html_foot.php");
?>
