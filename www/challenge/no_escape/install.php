<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install No Escape");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

/*
CREATE USER 'gizmore_noesc'@'localhost' IDENTIFIED BY 'gizmore_noesc';
CREATE DATABASE gizmore_noesc;
GRANT ALL ON gizmore_noesc.* TO 'gizmore_noesc'@'localhost' IDENTIFIED BY 'gizmore_noesc';
# Now execute install.php
*/
define('NO_ESCAPE_USER', 'gizmore_noesc');
define('NO_ESCAPE_DB', 'gizmore_noesc');
define('NO_ESCAPE_PW', 'gizmore_noesc');
require_once 'code.include';

noesc_createTable();

$title = 'No Escape';
$solution = false;
$score = 2;
$url = "challenge/no_escape/index.php";
$creators = "Gizmore";
$tags = 'Exploit,PHP,MySQL';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
