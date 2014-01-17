<?php
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Warchall: Nurxxed');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}
$solution = require_once 'challenge/warchall/nurxxed/www/solution.php';
$score = 6;
$url = 'challenge/warchall/nurxxed/index.php';
$creators = 'nurfed';
$tags = 'PHP,Exploit,Warchall';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
