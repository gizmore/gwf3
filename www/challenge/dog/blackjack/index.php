<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Blackjack Millionaire');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/dog/blackjack/index.php');
}
$chall->showHeader();
if (false !== ($answer = Common::getPostString('answer', false)))
{
	require_once 'challenge/dog/shadowdogs1/WC5Dog_Solution.php';
    blackjackSolver($chall, $answer);
}
echo GWF_Box::box($chall->lang('info', array()), $chall->lang('title'));
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
function blackjackSolver(WC_Challenge $chall, $answer)
{
	if (!GWF_Session::isLoggedIn())
	{
		echo GWF_HTML::error('Blackjack', 'Better login first!');
		return;
	}
	$code = WC5Dog_Solution::validateSolutionBJ($answer);
	switch ($code)
	{
		case 1:
			echo GWF_HTML::message('Blackjack', $chall->lang('msg_right'));
			$chall->onChallengeSolved(GWF_Session::getUserID());
			break;
		default:
			echo GWF_HTML::error('Blackjack', $chall->lang('err_wrong'));
			break;
	}
}
