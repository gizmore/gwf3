<?php
$solution = require 'secret.php';
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "ChATTACA");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 3;
$url = 'challenge/gizmore/chattaca/index.php';
$creators = 'gizmore';
$tags = 'Special';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
