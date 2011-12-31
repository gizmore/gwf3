<?php
chdir("../../../");
require_once("challenge/html_head.php");

if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = "Training: Encodings I";
$solution = "easystarter";
$score = 2;
$url = "challenge/training/encodings1/index.php";
$creators = "Gizmore";
$tags = 'Training,Encoding';

echo WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");

?>
