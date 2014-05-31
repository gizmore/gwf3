<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: Net Ports');
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = GWF_PAGE_TITLE;
$solution = false;
$score = 4;
$url = "challenge/training/net/ports/index.php";
$creators = "Gizmore";
$tags = 'HTTP,Coding';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
