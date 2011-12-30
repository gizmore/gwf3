<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install Crackcha");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$title = 'Crackcha';
$solution = false;
$score = 8;
$url = "challenge/crackcha/index.php";
$creators = "Gizmore";
$tags = 'Cracking,Image,Coding';

require_once 'challenge/crackcha/WC_Crackcha.php';

if (false === GDO::table('WC_Crackcha')->createTable(true)) {
	die('Can not install crackcha table');
}

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
