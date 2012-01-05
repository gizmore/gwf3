<?php
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'Preg Evasion';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 4;
$url = "challenge/noother/preg_evasion/index.php";
$creators = "noother";
$tags = 'Exploit,PHP';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
