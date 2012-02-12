<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Fremes');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/FREMES/index.php', false);
}
$chall->showHeader();

if (false !== ($answer = Common::getPostString('answer', false)))
{
	if (false === ($key = GWF_Session::get('FREMEN_KEY', false)))
	{
		echo GWF_HTML::error('Fremes', $chall->lang('err_try'));
	}
	else
	{
		$solution = GWF_Numeric::baseConvert($key, 2, 16);
		$slen = strlen($solution);
		$wlen = 128/4;
		$nlen = $wlen - $slen;
		$solution = str_repeat('0', $nlen).$solution;
		
		$answer = strtoupper($answer);
		$solution = strtoupper($solution);
		if ( ($answer === $solution) || (substr($answer, 2) === $solution) )
		{
			$chall->onChallengeSolved(GWF_Session::getUserID());
		}
		else
		{
			echo WC_HTML::error('err_wrong');
		}
	}
}


echo GWF_Box::box($chall->lang('info', array(128, 'fremes.php')), $chall->lang('title'));

echo formSolutionbox($chall);

require_once('challenge/html_foot.php');
?>