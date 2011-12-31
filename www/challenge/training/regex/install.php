<?php
chdir("../../../");
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = "Training: Regex";
$solution = false;
$score = 2;
$url = "challenge/training/regex/index.php";
$creators = "Gizmore";
$tags = 'Training,Regex';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>