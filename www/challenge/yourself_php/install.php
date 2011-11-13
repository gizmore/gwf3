<?php
chdir("../../");
require_once("html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}

$title = "Yourself PHP";
$solution = false;
$score = 4;
$url = "challenge/yourself_php/index.php";
$creators = "Gizmore,Kender";
$tags = 'PHP,Exploit,XSS';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags);

require_once("html_foot.php");
?>
