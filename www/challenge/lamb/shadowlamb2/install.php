<?php
chdir("../../../");
require_once("challenge/html_head.php");
define('GWF_PAGE_TITLE', 'Shadowlamb - Chapter II');
html_head("Install: ".GWF_PAGE_TITLE);
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 3;
$url = "challenge/lamb/shadowlamb2/index.php";
$creators = "Gizmore";
$tags = 'Fun';

require_once 'challenge/lamb/shadowlamb1/WC5Lamb_Solution.php';
if (false === GDO::table('WC5Lamb_Solution')->createTable(false))
{
	die('Oops 0815!');
}

WC_Challenge::installChallenge(GWF_PAGE_TITLE, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
