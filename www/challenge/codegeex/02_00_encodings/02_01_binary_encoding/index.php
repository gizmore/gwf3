<?php
$ds = DIRECTORY_SEPARATOR;
$challdir = getcwd() . $ds;
$i = strpos($challdir, "{$ds}challenge{$ds}");
$d = substr($challdir, 0, $i);
chdir($d);
define('NO_HEADER_PLEASE', true);
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/WC_CodegeexChallenge.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
$cgx = WC_CodegeexChallenge::byCWD($challdir);
$prob = $cgx->hasProblem();
$user = GWF_User::getStaticOrGuest();
$chall = $cgx->getChallenge();
$solution = $cgx->getSolution();
define('GWF_PAGE_TITLE', $chall->getTitle());
/** @var $gwf GWF3 **/
echo $gwf->onDisplayHead();# . '<div id="page_wrap">';
$chall->showHeader();
if ($prob)
{
	$problem = require "{$challdir}/problem.php";
	$solution = require "{$challdir}/solution.php";
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
}

echo GWF_Box::box($chall->lang('info', [$problem]), $chall->lang('title'));

// if ($cgx->hasVideo())
// {
// }

if ($prob)
{
	formSolutionbox($chall);
}

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
