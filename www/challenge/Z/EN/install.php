<?php
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Zen');
html_head('Install: '.GWF_PAGE_TITLE);
if (!GWF_User::isAdminS()) { return htmlSendToLogin('Better be admin !'); }


$title = GWF_PAGE_TITLE;
$solution = false;
$score = 5;
$url = 'challenge/Z/EN/index.php';
$creators = 'Gizmore';
$tags = 'Special,Crypto';
$verbose = true;
// $options = WC_Challenge::CHALL_CASE_I|WC_Challenge::CHALL_NO_SPACES|WC_Challenge::CHALL_HASHED_PW;

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, $verbose);

require_once('challenge/html_foot.php');
