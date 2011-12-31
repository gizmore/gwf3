<?php
chdir("../../../");
require_once("challenge/html_head.php");
html_head("Install Training: Programming 1");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Training: Programming 1";
$solution = "sdisdgsdgghusduihgsidughsduighsdiugsdiug1";
$score = 2;
$url = "challenge/training/programming1/index.php";
$creators = "Gizmore";
$tags = 'Training,Programming';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>