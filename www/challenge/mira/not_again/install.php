<?php
$plaintext = require 'secred.php';
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "NotAgain");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 8;
$url = 'challenge/mira/not_again/index.php';
$creators = 'gizmore,mira';
$tags = 'AI';

$solution = get_rect_or_die_trying($plaintext);

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
