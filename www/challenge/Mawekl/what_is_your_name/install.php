<?php
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'What is your Name?';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}

$solution = false;
$score = 7;
$url = "challenge/Mawekl/what_is_your_name/index.php";
$creators = "Mawekl";
$tags = 'Exploit,PHP,Coding';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
