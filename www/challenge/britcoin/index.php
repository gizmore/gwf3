<?php
require_once 'skein/skein_gwf3.php';
chdir('../../');
define('GWF_PAGE_TITLE', 'Britcoin');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/britcoin/index.php', false);
}

# Calculate payload and solution
$sess = GWF_User::isLoggedIn() ? GWF_User::getStaticOrGuest()->displayUsername() : GWF_Session::getSessID();
$payload = '<pre style="word-break:break-all; white-space:pre-wrap;">'.$chall->lang('payload', array($sess)).'</pre>';
$nounce_zero = GWF_Skein::hashString($payload);
$difficultyString = '00000000';

if (isset($_POST['answer']))
{
	$nounce = strtoupper($_POST['answer']);

	if (false !== ($error = $chall->isAnswerBlocked(GWF_User::getStaticOrGuest())))
	{
		echo $error;
	}
	elseif (!preg_match('#^[A-F0-9]{32}$#D', $nounce))
	{
		echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_nounce_fmt'), false);
	}
	else
	{
		$hash = GWF_Skein::hashString($nounce_zero.$nounce);
		if (Common::startsWith($hash, $difficultyString))
		{
			$chall->onChallengeSolved();
		}
		else
		{
			echo GWF_HTML::message('Brithash', $chall->lang('msg_nice_nounce'));
		}
	}
	
	
}


$chall->showHeader();

$hrefSpecs = '/challenge/britcoin/britcoinspecs.grfc';
echo GWF_Box::box($chall->lang('info', array($hrefSpecs, $payload, $nounce_zero, $difficultyString)), $chall->lang('title').' – '.$chall->lang('subtitle'));

require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
