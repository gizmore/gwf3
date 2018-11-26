<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Babbage and Coldplay');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/ludde/babbage_and_coldplay/index.php');
}
$chall->showHeader();
# -------------------------- #
if (false !== ($answer = Common::getPostString('answer', false)))
{
	$chall->onCheckSolution(md5(preg_replace('/[^a-z]/', '', strtolower($answer))));
}
# -------------------------- #
$href = 'babbage_and_coldplay.mp3';
echo GWF_Box::box($chall->lang('info', array($href)), $chall->lang('title'));
# -------------------------- #
echo formSolutionbox($chall);
# -------------------------- #
echo $chall->copyrightFooter();
require_once 'challenge/html_foot.php';
?>
