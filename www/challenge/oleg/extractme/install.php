<?php
$solution = require 'oleg_solution.php';
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'eXtract Me');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$score = 3;
$url = 'challenge/oleg/extractme/index.php';
$creators = 'oleg';
$tags = 'Encoding';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
?>
