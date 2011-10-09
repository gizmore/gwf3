<?php
chdir("../../");
define('GWF_PAGE_TITLE', 'Are you serial');
require_once("html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = GWF_PAGE_TITLE;
$solution = false;
$score = 2;
$url = "challenge/are_you_serial/index.php";
$creators = "Gizmore";
$tags = 'PHP';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("html_foot.php");
?>
