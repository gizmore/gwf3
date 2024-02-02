<?php
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "Eigentor");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
    return htmlSendToLogin('Better be admin!');
}
$score = 2;
$solution = false;
$url = 'challenge/eigentor/index.php';
$creators = 'gizmore';
$tags = 'Special';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
