<?php
chdir("../../../");
require_once("challenge/html_head.php");
define('GWF_PAGE_TITLE', 'PHP 0818');
html_head("Install: ".GWF_PAGE_TITLE);
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 3;
$url = "challenge/noother/php0818/index.php";
$creators = "noother";
$tags = 'Exploit,PHP';
WC_Challenge::installChallenge(GWF_PAGE_TITLE, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
