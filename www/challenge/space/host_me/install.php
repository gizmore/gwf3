<?php
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'HOST me');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$solution = false;
$score = 2;
$url = 'challenge/space/host_me/index.php';
$creators = 'space';
$tags = 'PHP,HTTP';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
