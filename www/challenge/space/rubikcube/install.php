<?php

chdir('../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', "Rubik's Cube");
$title = GWF_PAGE_TITLE;
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin!');
}
$solution = false;
$score = 3;
$url = 'challenge/space/rubikcube/index.php';
$creators = 'space';
$tags = 'Fun,Logic,Coding';

function rubikInstall()
{
	$db = gdo_db();
	$query =
		"CREATE TABLE IF NOT EXISTS rubik (".
		"sessid INT(11) UNSIGNED PRIMARY KEY NOT NULL, ".
		"cube CHAR(54) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL, ".
		"moves INT(11) UNSIGNED NOT NULL DEFAULT 0, ".
		"level INT(11) UNSIGNED NOT NULL DEFAULT 0 ".
		") ENGINE=myISAM";
	return $db->queryWrite($query);
}

if (false === rubikInstall()) {
	die('DB Error!');
}

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');
