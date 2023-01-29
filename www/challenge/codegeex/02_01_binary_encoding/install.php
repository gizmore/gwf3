<?php
chdir("../../../../");
require_once("challenge/html_head.php");
html_head("CGX: Binary Encoding");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}
$title = 'CGX: Binary Encoding';
$solution = false;
$score = 1;
$url = "challenge/coding_ala_giz/02_01_binary_encoding/index.php";
$creators = "gizmore,aLLamoox";
$tags = 'Encoding,Training,CGX';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
