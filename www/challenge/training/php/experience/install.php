<?php
define('GWF_PAGE_TITLE', 'Experience');
$data = require('data.php');
$solution = require('solution.php');
require_once 'expdb.php';
chdir('../../../../');
require_once("challenge/html_head.php");
//html_head("Install Addslashes");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}

// $title = GWF_PAGE_TITLE;
$solution = $solution;
$score = 4;
$url = "challenge/training/php/experience/index.php";
$creators = "Gizmore";
$tags = 'MySQL,PHP,Exploit';

WC_Challenge::installChallenge(GWF_PAGE_TITLE, $solution, $score, $url, $creators, $tags);

if (!$db = gdo_db_instance(EXP_DB_HOST, EXP_DB_USER, EXP_DB_PASS, EXP_DB_NAME))
{
	die(GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)));
}

$db->truncateTable('items');
$db->truncateTable('flags');
foreach ($data as $title)
{
	$title = $db->escape($title);
	$db->queryWrite("INSERT INTO items VALUES(0, '$title', NOW())");
}

$challenges = GDO::table('WC_Challenge')->selectObjects('*');
foreach ($challenges as $challenge)
{
	$challenge instanceof WC_Challenge;
	$random_solution = GWF_Random::randomKey(32);
	$db->queryWrite("INSERT INTO flags VALUES({$challenge->getID()}, '$random_solution')");
}
$challenge = WC_Challenge::getByTitle(GWF_PAGE_TITLE, false);
$db->queryWrite("REPLACE INTO flags VALUES({$challenge->getID()}, '$solution')");


require_once("challenge/html_foot.php");
