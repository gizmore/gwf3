<?php
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "Fineprint");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$solution = false;
$score = 4;
$url = 'challenge/gizmore/fineprint/index.php';
$creators = 'Gizmore';
$tags = 'Exploit,Training';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
