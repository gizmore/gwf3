<?php
chdir('../../../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Encodings: URL');
html_head("Install ".GWF_PAGE_TITLE);
if (!GWF_User::isAdminS())
{
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	$_GET['no_session'] = 1;
	require_once("challenge/html_foot.php");
	return;
}
$title = GWF_PAGE_TITLE;
$solution = false;
$score = 1;
$url = "challenge/training/encodings/url/index.php";
$creators = "Gizmore";
$tags = 'Training,Encoding';
WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);
require_once("challenge/html_foot.php");
?>
