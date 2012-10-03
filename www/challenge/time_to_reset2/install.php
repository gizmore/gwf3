<?php
chdir("../../");
define('GWF_PAGE_TITLE', 'Time to Reset II');
require_once("challenge/html_head.php");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}
$title = GWF_PAGE_TITLE;
$solution = false;
$score = 7;
$url = "challenge/time_to_reset2/index.php";
$creators = "Gizmore,noother";
$tags = 'Exploit,Coding,PHP';

require_once 'challenge/time_to_reset2/TTR2_Tokens.include';
if (!GDO::table('TTR2_Tokens')->createTable(true))
{
	echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	return;
}

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
