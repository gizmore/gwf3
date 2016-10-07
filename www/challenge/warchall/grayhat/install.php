<?php
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Warchall: Grayhat');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}
$solution = require_once 'challenge/warchall/grayhat/grayhat_download_site/solution.php';
$score = 3;
$url = 'challenge/warchall/grayhat/index.php';
$creators = 'gizmore';
$tags = 'Warchall';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
