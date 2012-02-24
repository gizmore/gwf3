<?php
chdir("../../");
require_once("challenge/html_head.php");
define('GWF_PAGE_TITLE', 'Burning Fox');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$solution = require 'challenge/burning_fox/burning_fox_solution.php';
$score = 4;
$url = "challenge/burning_fox/index.php";
$creators = "Gizmore";
$tags = 'Cracking';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
