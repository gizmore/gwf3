<?php
chdir("../../../");
require_once("html_head.php");
$title = 'Smile';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 4;
$url = "challenge/livinskull/smile/index.php";
$creators = "livinskull,Gizmore";
$tags = 'Exploit,PHP';

require_once 'challenge/livinskull/smile/LIVIN_Smile.php';
if (false === GDO::table('LIVIN_Smile')->createTable(true))
{
	die('Oops 0815!');
}

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("html_foot.php");
?>
