<?php
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "Few Bonaccis");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
    return htmlSendToLogin('Better be admin!');
}
$score = 3;
$solution = false;
$url = 'challenge/fewbonaccis/index.php';
$creators = 'gizmore';
$tags = 'Coding,Math';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
