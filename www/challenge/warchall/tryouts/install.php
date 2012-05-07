<?php
chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Warchall: Tryouts');
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}
$solution = require_once 'challenge/warchall/tryouts/tryouts_solution.php';
$score = 5;
$url = 'challenge/warchall/tryouts/index.php';
$creators = 'matrixman';
$tags = 'Linux,Exploit,Warchall';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
?>
