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
define('GWF_PAGE_TITLE', $chall->getTitle());
/** @var $gwf GWF3 **/
echo $gwf->onDisplayHead();
$chall->showHeader();
if ($prob)
{
	$solution = $cgx->getSolution();
	if (isset($_POST['answer']))
	{
		if (false !== ($error = $chall->isAnswerBlocked($user)))
		{
			echo $error;
		}
		elseif (!strcasecmp($_POST['answer'], (string)$solution))
		{
			$chall->onChallengeSolved($user->getID());
		}
		else
		{
			echo WC_HTML::error('err_wrong');
		}
	}
}
else
{
	$cgx->markAuxilarySolved();
}

echo $cgx->getInfoBox();

echo $cgx->getSolverBox();

if ($prob)
{
	echo $cgx->getProblemBox();
	formSolutionbox($chall);
}

echo $cgx->getDraftBox();

if ($cgx->hasVideo())
{
	echo $cgx->getVideoBoxes();
}

echo GWF_Box::box("(c) 2000-2023 bb");
require_once('challenge/html_foot.php');
