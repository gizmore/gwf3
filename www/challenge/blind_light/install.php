<?php
require_once 'settings.php';
require_once 'vuln.php';

chdir("../../");
require_once("html_head.php");
$title = 'Blinded by the light';
html_head("Install: $title");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 4;
$url = "challenge/blind_light/index.php";
$creators = "gizmore";
$tags = 'MySQL,Exploit';

if (false === blightInstall())
{
	die('DB ERROR!');
}

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("html_foot.php");

?>