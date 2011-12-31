<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Shadowlamb - Chapter I');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/lamb/shadowlamb1/index.php');
}
$chall->showHeader();
if (false !== ($answer = Common::getPostString('answer', false)))
{
	require_once 'challenge/lamb/shadowlamb1/WC5Lamb_Solution.php';
	shadowlamb1solver($chall, $answer);
}
echo GWF_Box::box($chall->lang('info', array('client.php')), $chall->lang('title'));
echo formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
<?php
function shadowlamb1solver(WC_Challenge $chall, $answer)
{
//	$wechall = Module_WeChall::instance();
	$code = WC5Lamb_Solution::validateSolution1($answer, GWF_Session::getUserID());
	switch ($code)
	{
		case 1:
			echo GWF_HTML::message('Shadowlamb', $chall->lang('msg_right'));
			$chall->onChallengeSolved(GWF_Session::getUserID());
			break;
		default:
			echo GWF_HTML::error('Shadowlamb', $chall->lang('err_wrong_'.$code));
			break;
	}
}
?>