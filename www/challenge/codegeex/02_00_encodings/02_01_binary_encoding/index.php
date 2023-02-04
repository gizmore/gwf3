<?php
define('NO_HEADER_PLEASE', true);
$challdir = getcwd();
chdir('../../../');
// define('GWF_PAGE_TITLE', 'CGX: Binary Encoding');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
$cgx = WC_CodegeexChallenge::byCWD($challdir);

echo $gwf->onDisplayHead();# . '<div id="page_wrap">';

if (false === ($chall = WC_CodegeexChallenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/coding_ala_giz/02_01_binary_encoding/index.php', false);
}
$chall->showHeader();

function generateSolution()
{
	if (!($sol = GWF_Session::get('cag01')))
	{
		$sol = re;
		GWF_Session::set('cag01', $sol);
	}
	return $sol;
}
$user = GWF_User::getStaticOrGuest();
$problem = generateSolution();
$solution = bindec($problem);

if (isset($_POST['answer']))
{
	if (false !== ($error = $chall->isAnswerBlocked($user)))
	{
		echo $error;
	}
	elseif ((string)$_POST['answer'] === (string)$solution)
	{
		$chall->onChallengeSolved($user->getID());
	}
	else
	{
		echo WC_HTML::error('err_wrong');
	}
}

echo GWF_Box::box($chall->lang('info', [$problem]), $chall->lang('title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
