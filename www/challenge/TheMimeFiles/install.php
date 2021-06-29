<?php
chdir("../../");
require_once("challenge/html_head.php");
$title = 'Temper';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
    return htmlSendToLogin("Better be admin !");
}
$score = 3;
$url = "challenge/TheMimeFiles/index.php";
$creators = "gizmore";
$tags = 'Exploit';
$solution = require 'www/solution.php';
$verbose = true;

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose);

require_once("challenge/html_foot.php");
