<?php
chdir("../../../../");
require_once("challenge/html_head.php");
html_head("Install Training: Math Pyramid");
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}
$title = 'Training: Math Pyramid';
$solution = false;
$score = 2;
$url = "challenge/training/math/pyramid/index.php";
$creators = "Gizmore";
$tags = 'Math,Training';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
