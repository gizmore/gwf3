<?php
chdir("../../../");
require_once("challenge/html_head.php");
define('GWF_PAGE_TITLE', 'Shadowlamb - Chapter IV');
html_head("Install: ".GWF_PAGE_TITLE);
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 5;
$url = "challenge/lamb/shadowlamb4/index.php";
$creators = "Gizmore";
$tags = 'Fun';

WC_Challenge::installChallenge(GWF_PAGE_TITLE, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
