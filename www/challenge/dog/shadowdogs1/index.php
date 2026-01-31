<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Shadowdogs - Chapter I');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/dog/shadowdogs/index.php');
}
$chall->showHeader();
if (false !== ($answer = Common::getPostString('answer', false)))
{
	require_once 'challenge/dog/shadowdogs/WC5Dog_Solution.php';
	shadowdogs4solver($chall, $answer);
}
echo GWF_Box::box($chall->lang('info', array()), $chall->lang('title'));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
function shadowdogs4solver(WC_Challenge $chall, $answer)
{
	if (!GWF_Session::isLoggedIn())
	{
		echo GWF_HTML::error('Shadowdogs', 'Better login first!');
		return;
	}
	$code = WC5Dog_Solution::validateSolution4($answer);
	switch ($code)
	{
		case 1:
			echo GWF_HTML::message('Shadowdogs', $chall->lang('msg_right'));
			$chall->onChallengeSolved(GWF_Session::getUserID());
			break;
		default:
			echo GWF_HTML::error('Shadowdogs', $chall->lang('err_wrong_'.$code));
			break;
	}
}
