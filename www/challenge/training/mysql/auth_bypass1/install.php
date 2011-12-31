<?php
chdir("../../../../");
require_once("challenge/html_head.php");
html_head("Install Training: MySQL I");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}

/*
CREATE USER 'gizmore_auth1'@'localhost' IDENTIFIED BY 'AuthIsBypass';
CREATE DATABASE gizmore_auth1;
GRANT SELECT ON gizmore_auth1.* TO 'gizmore_auth1'@'localhost' IDENTIFIED BY 'AuthIsBypass';
USE gizmore_auth1;
CREATE TABLE IF NOT EXISTS users
(
userid    INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username  VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
password  CHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL 
)
ENGINE=myISAM;
INSERT INTO users VALUES(1, 'AaronAAaronson', md5('yunofail'));
INSERT INTO users VALUES(2, 'Admin', md5('FutharkIsNotAPass'));
INSERT INTO users VALUES(3, 'When', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(4, 'you', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(5, 'can', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(6, 'read', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(7, 'this', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(8, 'you', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(9, 'really', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(10, 'need', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(11, 'to', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(12, 'get', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(13, 'laid', md5('ThePassIsNotToGetCracked'));
*/

$title = 'Training: MySQL I';
$solution = false;
$score = 2;
$url = "challenge/training/mysql/auth_bypass1/index.php";
$creators = "Gizmore";
$tags = 'MySQL,Exploit,Training';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
