<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Training: Stegano I');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle("Training: Stegano I"))) {
	$chall = WC_Challenge::dummyChallenge("[Training: Stegano I]");
}
$chall->showHeader();
$chall->onCheckSolution();
echo GWF_Box::box($chall->lang('info').'<br/><img src="stegano1.bmp" width="64" height="64" />', GWF_PAGE_TITLE);
formSolutionbox($chall);
require_once("challenge/html_foot.php");
?>
