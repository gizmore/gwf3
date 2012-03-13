<?php
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Repeating History');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}

$solution = '2bda2998d9b0ee197da142a0447f6725';
$score = 2;
$url = 'challenge/subversive/history/index.php';
$creators = 'spaceone,Gizmore';
$tags = 'Research';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
?>
