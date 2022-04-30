<?php
$solution = require 'solution.php';
chdir("../../../");
define('GWF_PAGE_TITLE', 'LoFi');
require_once("challenge/html_head.php");
html_head(GWF_PAGE_TITLE);
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

$title = GWF_PAGE_TITLE;
$score = 1;
$url = "challenge/guesswork/LoFi/index.php";
$creators = "Gizmore";
$tags = 'Exploit,Special';

echo WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, 0);

require_once("challenge/html_foot.php");
