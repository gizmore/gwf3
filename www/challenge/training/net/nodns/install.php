<?php
chdir("../../../../");
require_once("challenge/html_head.php");
$title = 'Training: No DNS';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
    return htmlSendToLogin("Better be admin !");
}
$score = 1;
$url = "challenge/training/net/nodns/index.php";
$creators = "gizmore";
$tags = 'Training,Network';
$solution = false;
$verbose = true;

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose);

require_once("challenge/html_foot.php");
