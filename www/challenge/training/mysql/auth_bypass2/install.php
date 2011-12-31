<?php
chdir("../../../../");
require_once("challenge/html_head.php");
html_head("Install Training: MySQL II");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}

/*
CREATE USER 'gizmore_auth2'@'localhost' IDENTIFIED BY 'AuthIsBypassTwo';
CREATE DATABASE gizmore_auth2;
GRANT SELECT ON gizmore_auth2.* TO 'gizmore_auth2'@'localhost' IDENTIFIED BY 'AuthIsBypassTwo';
USE gizmore_auth2;
CREATE TABLE IF NOT EXISTS users
(
userid    INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username  VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
password  CHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL 
)
ENGINE=myISAM;
INSERT INTO users VALUES(1, 'AaronBBison', md5('yunofail??'));
INSERT INTO users VALUES(2, 'Admin', md5('FuzyyIsNotAPassEither'));
INSERT INTO users VALUES(3, 'A', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(4, 'good', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(5, 'question', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(6, 'is', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(7, 'worth', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(8, 'more', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(9, 'than', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(10, 'two', md5('ThePassIsNotToGetCracked'));
INSERT INTO users VALUES(11, 'answers', md5('ThePassIsNotToGetCracked'));
*/

$title = 'Training: MySQL II';
$solution = false;
$score = 2;
$url = "challenge/training/mysql/auth_bypass2/index.php";
$creators = "Gizmore";
$tags = 'MySQL,Exploit,Training';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
