<?php
chdir("../../");
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = "Can you read me";
$solution = false;
$score = 5;
$url = "challenge/can_you_readme/index.php";
$creators = "Gizmore";
$tags = 'Coding,Image';
htmlDisplayError(WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true));
require_once("challenge/html_foot.php");
?>
