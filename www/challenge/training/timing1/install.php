<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Training: Time is of the Essence');
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = GWF_PAGE_TITLE;
$solution = require 'challenge/training/timing1/password.php';
$score = 3;
$url = "challenge/training/timing1/index.php";
$creators = "Gizmore,tehron";
$tags = 'Training,Programming,Exploit';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
