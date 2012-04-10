<?php
$solution = require 'foo_solution.php';
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'foo');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 2;
$url = 'challenge/space/foo/index.php';
$creators = 'space';
$tags = 'Fun';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
