<?php
require_once 'settings.php';
require_once 'vuln.php';

chdir("../../../");
require_once("challenge/html_head.php");
$title = 'Are you blind?';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 6;
$url = "challenge/Mawekl/are_you_blind/index.php";
$creators = "Mawekl";
$tags = 'MySQL,Exploit';

if (false === blightInstall())
{
	die('DB ERROR!');
}

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");

?>