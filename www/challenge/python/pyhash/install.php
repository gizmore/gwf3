<?php
$solution = require 'secret.php';
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "PyHash");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
    return htmlSendToLogin('Better be admin!');
}
$score = 2;
$url = 'challenge/python/pyhash/index.php';
$creators = 'gizmore';
$tags = 'Coding,Python';

WC_Challenge::installChallenge($title, $solution[1], $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
