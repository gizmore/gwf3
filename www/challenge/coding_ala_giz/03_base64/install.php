<?php
$solution = require 'solution2.php';;
chdir("../../../../");
require_once("challenge/html_head.php");
html_head("CAG: Binary Encoding BE");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}
$title = 'CAG: Base64';
$score = 1;
$url = "challenge/coding_ala_giz/03_base64/index.php";
$creators = "gizmore,aLLamoox";
$tags = 'Encoding,Training,CAG';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
