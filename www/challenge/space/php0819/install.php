<?php
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'PHP 0819');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$solution = false;
$score = 2;
$url = 'challenge/space/php0819/index.php';
$creators = 'space';
$tags = 'PHP';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
