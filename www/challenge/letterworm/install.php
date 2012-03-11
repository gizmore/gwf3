<?php
chdir("../../");
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	return htmlDisplayError("You need to be admin");
}
$title = "Letterworm";
$solution = false;
$score = 6;
$url = "challenge/letterworm/index.php";
$creators = "Gizmore";
$tags = "Coding";
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
