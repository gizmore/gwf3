<?php
$solution = require 'secret.php';
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "Valentine's Gold");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 5;
$url = 'challenge/valentines_gold/index.php';
$creators = 'gizmore,tehron';
$tags = 'Math,Coding';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_I);

require_once('challenge/html_foot.php');
