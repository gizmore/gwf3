<?php
chdir('../../../../');
require_once('challenge/html_head.php');
html_head("Install Training: ASCII");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}
$title = 'Training: ASCII';
$solution = false;
$score = 1;
$url = "challenge/training/encodings/ascii/index.php";
$creators = "Gizmore";
$tags = 'Training,Encoding';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
