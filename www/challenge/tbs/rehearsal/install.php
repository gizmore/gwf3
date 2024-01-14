<?php
$solution = 'secret.php';
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "TBS Rehearsal");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 1;
$url = 'challenge/tbs/rehearsal/index.php';
$creators = 'gizmore,theAnswer';
$tags = 'CGX,Stegano';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
