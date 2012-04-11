<?php
$solution = require 'pytong_solution.php';
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Py-Tong');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 2;
$url = 'challenge/space/pytong/index.php';
$creators = 'space';
$tags = 'Fun';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
