<?php
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Zen');
html_head('Install: '.GWF_PAGE_TITLE);
if (!GWF_User::isAdminS()) { return htmlSendToLogin('Better be admin !'); }


$title = GWF_PAGE_TITLE;
$solution = '';
$score = 2;
$url = 'challenge/Z/EN/index.php';
$creators = 'Gizmore';
$tags = 'Special,Crypto';
$verbose = true;
$options = WC_Challenge::CASE_I|WC_Challenge::NO_SPACES|WC_Challenge::HASHED_PASSWORD;

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose, $options);

require_once('challenge/html_foot.php');
