<?php
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Warchall: Live RCE');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}
$solution = require_once 'challenge/warchall/live_rce/www/solution.php';
$score = 4;
$url = 'challenge/warchall/live_rce/index.php';
$creators = 'gizmore';
$tags = 'PHP,Exploit,Warchall';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
