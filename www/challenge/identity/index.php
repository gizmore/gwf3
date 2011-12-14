<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Identity');
require_once('html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/identity/index.php', false);
}
$chall->showHeader();


$score_needed = 500;
$title = $chall->lang('title');


if (false !== ($user = GWF_Session::getUser()))
{
	if ($user->getLevel() >= $score_needed)
	{
		if (isset($_POST['answer']))
		{
			$pre = $_POST['answer'];
			identity_filter($chall);
			$chall->onCheckSolution();
			$_POST['answer'] = $pre;
		}
		
		$gizmore = GWF_User::getByName('gizmore');
		$profile = $gizmore->displayProfileLink();
		echo GWF_Box::box($chall->lang('info', array($profile)), $title);
		
		require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
		echo formSolutionbox($chall);
	}
	else
	{
		$score = $user->getLevel();
		echo GWF_HTML::error($title, $chall->lang('err_score', array($score, $score_needed)));
	}
}
else
{
	echo GWF_HTML::error($title, $chall->lang('err_login'));
}

echo $chall->copyrightFooter();
require_once('html_foot.php');
?>

<?php
function identity_filter(WC_Challenge $chall)
{
	if ( (!isset($_POST['answer'])) || (is_string($_POST['answer'])) )
	{
		return;
	}
	
	$answer = $_POST['answer'];
	$answer = str_replace(array(' ',','), '', $answer);
	$answer = strtolower($answer);
	$answer = str_replace('049', '0', $answer);

	if (strpos($answer, '17659598844') !== false)
	{
		echo GWF_HTML::error($chall->lang('title'), $chall->lang('err_home_phone'));
	}
	
	$_POST['answer'] = $answer;
}
?>