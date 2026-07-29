<?php
$solution = require 'secred.php';
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "Errection");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 2;
$url = 'challenge/mira/errection/index.php';
$creators = 'gizmore,mira';
$tags = 'AI';

WC_Challenge::installChallenge($title, calculator($solution), $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
