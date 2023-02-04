<?php
chdir("../../../../");
require_once("challenge/html_head.php");
html_head("CGX: Binary Encoding BE");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}
$title = 'CGX: Binary Encoding BE';
$solution = false;
$score = 1;
$url = "challenge/coding_ala_giz/02_04_still_binary/index.php";
$creators = "gizmore,x";
$tags = 'Encoding,Training,CGX';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
