<?php
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Britcoin');
$title = GWF_PAGE_TITLE;
html_head('Install: '.$title);
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}
$solution = false;
$score = 3;
$url = 'challenge/britcoin/index.php';
$creators = 'Gizmore';
$tags = 'Coding';


WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
