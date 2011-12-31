<?php
chdir("../../");
define('GWF_PAGE_TITLE', 'Connect the dots');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle('Connect the Dots'))) {
	$chall = WC_Challenge::dummyChallenge('Connect The Dots');
}
$chall->showHeader();
$chall->onCheckSolution();
$alt = $chall->lang('img_alt');
echo GWF_Box::box($chall->lang('info', array(GWF_WEB_ROOT.'profile/galen')).'<br/><img src="dots.jpg" alt="'.$alt.'" title="'.$alt.'" />');
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
