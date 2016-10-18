<?php
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Wanda');
$title = GWF_PAGE_TITLE;
html_head('Install: '.$title);
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}
$solution = 'E1C2C91B0C1AFCF97FCFF0EFE148D5C8';
$score = 2;
$url = 'challenge/wanda/index.php';
$creators = 'Gizmore';
$tags = 'Fun,Exploit';


WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
