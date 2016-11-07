<?php
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'World of Wonders');
$title = GWF_PAGE_TITLE;
html_head('Install: '.$title);
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}

$options = WC_Challenge::CASE_I;
$options = WC_Challenge::NO_SPACES;
$options = WC_Challenge::HASHED_PASSWORD;
$solution = '';

$score = 7;
$url = 'challenge/world_of_wonders/index.php';
$creators = 'Gizmore';
$tags = 'Fun,Stegano';



WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, $options);

require_once('challenge/html_foot.php');
