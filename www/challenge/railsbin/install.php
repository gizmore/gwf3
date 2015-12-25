<?php
$solution = require('railsbin.solution.php');
chdir("../../");
define('GWF_PAGE_TITLE', 'Railsbin');
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = GWF_PAGE_TITLE;
#$solution = "test";
$score = 5;
$url = "challenge/railsbin/index.php";
$creators = "Gizmore";
$tags = 'Exploit';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
