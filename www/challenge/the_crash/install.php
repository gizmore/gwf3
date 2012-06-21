<?php
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'The Crash');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}
$solution = false;
$score = 4;
$url = 'challenge/the_crash/index.php';
$creators = 'Gizmore';
$tags = 'Crypto,Programming';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
?>
