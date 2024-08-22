<?php
include 'stalking_solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'Stalking');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 10, 'challenge/identity/stalking/index.php', false);
}
$chall->showHeader();

# That would be you!
$user = GWF_User::getStaticOrGuest();

# Get prerequisite challenge
if (false === ($identity = WC_Challenge::getByTitle('Identity')))
{
	echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
}

# Did not solve prerequisite yet?
else if (!WC_ChallSolved::hasSolved($user->getID(), $identity->getID()))
{
	$ida = sprintf('<a href="%s">%s</a>', htmlspecialchars($identity->hrefChallenge()), htmlspecialchars($identity->getName()));
	echo GWF_HTML::error($chall->lang('title'), $chall->lang('err_identity', [$ida]));
}

else # We can submit answers 
{
	# Did we get an anwer at all?
	if ('' !== ($answer = Common::getPostString('answer', '')))
	{
		# Bruteforcing answers?
		if (false !== ($error = $chall->isAnswerBlocked($user)))
		{
			echo $error;
		}
			
		# Is the answer correct? (nah!)
		elseif (false !== ($error = stalking_check_answer($chall, $answer)))
		{
			echo GWF_HTML::error($chall->lang('title'), $error);
		}
		
		# Yes, it is correct. The impossible has happened
		else
		{
			echo GWF_HTML::message($chall->lang('title'), $chall->lang('msg_correct'));
			$chall->onChallengeSolved($user->getID());
		}
	}
	
	# Always show InfoBox
	echo GWF_Box::box($chall->lang('info'), $chall->lang('title'));
	
	require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
	echo formSolutionbox($chall);
}

# That would be me!
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
