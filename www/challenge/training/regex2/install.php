<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Training: RegexMini');
require_once("html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = GWF_PAGE_TITLE;
$solution = false;
$score = 2;
$url = "challenge/training/regex2/index.php";
$creators = "ludde";
$tags = 'Training,Regex';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("html_foot.php");
?>