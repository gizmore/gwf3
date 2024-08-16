<?php
$solution = require 'secret.php';
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "No Action");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
    return htmlSendToLogin('Better be admin!');
}
$score = 1;
$url = 'challenge/no_action/indice.php';
$creators = 'gizmore';
$tags = 'Coding,HTTP';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
