<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'PHP My Admin');
require_once('challenge/html_head.php');
$title = GWF_PAGE_TITLE;
html_head('Install: '.$title);
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}
$solution = false;
$score = 3;
$url = 'challenge/php_my_admin/index.php';
$creators = 'Gizmore';
$tags = 'Research';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once('challenge/html_foot.php');
?>
