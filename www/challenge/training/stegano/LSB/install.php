<?php
chdir("../../../../");
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = "Training: LSB";
$solution = false;
$score = 2;
$url = "challenge/training/stegano/LSB/index.php";
$creators = "Gizmore";
$tags = 'Stegano,Image,Training';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
