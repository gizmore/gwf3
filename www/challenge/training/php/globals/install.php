<?php
chdir("../../../../");
require_once("challenge/html_head.php");
html_head("Install Training: Register Globals");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}

function wc_rg_install()
{
	$query =
		"CREATE TABLE IF NOT EXISTS ".GWF_TABLE_PREFIX."wc_chall_reg_glob (".
		"userid INT(11) AUTO_INCREMENT PRIMARY KEY, ".
		"username VARCHAR(63) CHARACTER SET utf8 COLLATE utf8_general_ci UNIQUE, ".
		"password CHAR(32) CHARACTER SET ascii COLLATE ascii_bin, ".
		"level INT(11) NOT NULL DEFAULT 0 ".
		") ENGINE=myIsam";
	return gdo_db()->queryWrite($query);
}
if (false === wc_rg_install()) {
	die('ERROR in Table install.');
}

$users = array(
	array('Aaron. A. Aaronson', 'thismypass', 0x111),
	array('Admin', 'ZOMGPASSATTACKS!!!!', 0xfff),
	array('Peter', 'Peter', 0x222),
	array('Paul', 'Paul', 0x333),
	array('Mary', 'Mary', 0x444),
	array('test', 'test', 0x555),
	array('Lamb', 'Lamb', 0x666),
);
$db = gdo_db();
foreach ($users as $i => $data)
{
	list($user, $pass, $level) = $data;
	$user = $db->escape($user);
	$pass = md5($pass);
	$query = "REPLACE INTO ".GWF_TABLE_PREFIX."wc_chall_reg_glob VALUES($i, '$user', '$pass', $level)";
	if (false === $db->queryWrite($query)) {
		die('OOPS');
	}
}


$title = 'Training: Register Globals';
$solution = false;
$score = 2;
$url = "challenge/training/php/globals/index.php";
$creators = "Gizmore";
$tags = 'Exploit,PHP,Training';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
