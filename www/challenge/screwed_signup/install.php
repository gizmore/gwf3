<?php
chdir("../../");
require_once("challenge/html_head.php");
html_head("Install Screwed Signup");
if (!GWF_User::isAdminS()) {
	return htmlSendToLogin("Better be admin !");
}

# Create the tables
require_once 'screwed_signup.include';
screwed_signupCreateUserTable();
/*
CREATE TABLE IF NOT EXISTS `chall_sql1` ( `username` VARCHAR(24) NOT NULL,  `password` VARCHAR(32) NOT NULL,  `access_level` INT(10) UNSIGNED NOT NULL DEFAULT 0);
INSERT INTO `chall_sql1` VALUES ( 'Admin', 'xxx', 1337)
*/
$title = "Screwed Signup";
$solution = false;
$score = 7;
$url = "challenge/screwed_signup/index.php";
$creators = "Gizmore";
$tags = 'Exploit,PHP,MySQL';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once("challenge/html_foot.php");
?>
