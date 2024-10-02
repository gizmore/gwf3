<?php
$solution = false;
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "MD5 Broken");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 4;
$url = 'challenge/MD5.BROKEN/index.php';
$creators = 'gizmore';
$tags = 'Cracking,Coding';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_I);

require_once('challenge/html_foot.php');
