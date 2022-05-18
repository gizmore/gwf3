<?php
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'IRC: Duckhunt';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
    return htmlSendToLogin("Better be admin !");
}
$score = 1;
$url = "challenge/irc/duckhunt/index.php";
$creators = "gizmore";
$tags = 'Fun';
$solution = false;
$verbose = true;

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose);

require_once("challenge/html_foot.php");
