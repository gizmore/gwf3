<?php
chdir("../../../");
require_once("html_head.php");
$title = 'Stop us';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 3;
$url = "challenge/noother/stop_us/index.php";
$creators = "noother,gizmore";
$tags = 'Exploit,PHP';

require_once 'challenge/noother/stop_us/noothtable.php';
if (false === GDO::table('noothtable')->createTable(true))
{
	die('ouch');
}

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("html_foot.php");
?>
