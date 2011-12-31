<?php
chdir("../../");
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = "Snake";
$solution = false;
$score = 7;
$url = "challenge/snake/index.php";
$creators = "Gizmore";
$tags = 'Java,PHP,Fun';

$_GET['installing'] = true;
require_once 'CGI_Highscore.php';
GDO::table('Snake_row')->createTable(true);

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>