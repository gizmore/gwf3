<?php
chdir("../../");
require_once("challenge/html_head.php");
$title = 'Temper';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
    return htmlSendToLogin("Better be admin !");
}
$score = 7;
$url = "challenge/temper/index.php";
$creators = "jusb3";
$tags = 'Crypto,Exploit';
$solution = false;
$verbose = true;

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose);

require_once("challenge/html_foot.php");
