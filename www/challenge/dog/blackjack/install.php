<?php
chdir("../../../");
require_once("challenge/html_head.php");
define('GWF_PAGE_TITLE', 'Blackjack');
html_head("Install: ".GWF_PAGE_TITLE);
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 2;
$url = "challenge/dog/blackjack/index.php";
$creators = "gizmore";
$tags = 'Fun,Logic';

require_once 'challenge/dog/shadowdogs1/WC5Dog_Solution.php';
if (false === GDO::table('WC5Dog_Solution')->createTable(false))
{
	die('Oops 0815!');
}

WC_Challenge::installChallenge(GWF_PAGE_TITLE, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
