<?php
chdir("../../../../");
require_once("challenge/html_head.php");
html_head("Install Training: Baconian");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}
$title = 'Training: Baconian';
$solution = false;
$score = 2;
$url = "challenge/training/encodings/bacon/index.php";
$creators = "Gizmore";
$tags = 'Encoding,Crypto,Training';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
