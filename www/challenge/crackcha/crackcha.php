<?php
define('WCC_CRACKCHA_NEED', 468); # need to crack 600
define('WCC_CRACKCHA_TIME', 1800); # within 30 minutes

function crackcha_reset(WC_Challenge $chall)
{
	GWF_Session::set('WCC_CRACKCHA_START', microtime(true));
	GWF_Session::set('WCC_CRACKCHA_COUNT', 0);
	GWF_Session::set('WCC_CRACKCHA_SOLVED', 0);
	GWF_Session::remove('WCC_CRACKCHA_CHARS');
	
	return $chall->lang('msg_reset', array(WCC_CRACKCHA_TIME, WCC_CRACKCHA_NEED));
}

function crackcha_increase_count()
{
	GWF_Session::set('WCC_CRACKCHA_COUNT', (GWF_Session::getOrDefault('WCC_CRACKCHA_COUNT', 0)+1));
}

function crackcha_increase_solved()
{
	GWF_Session::set('WCC_CRACKCHA_SOLVED', (GWF_Session::getOrDefault('WCC_CRACKCHA_SOLVED', 0)+1));
}

function crackcha_solved()
{
	return GWF_Session::getOrDefault('WCC_CRACKCHA_SOLVED', 0) >= WCC_CRACKCHA_NEED;
}

function crackcha_round_over()
{
	return crackcha_elapsed() > WCC_CRACKCHA_TIME;
}

function crackcha_elapsed()
{
	$start = GWF_Session::getOrDefault('WCC_CRACKCHA_START', 0);
	$now = microtime(true);
	return $now - $start;
}

function crackcha_insert_high($chall)
{
	require_once 'challenge/crackcha/WC_Crackcha.php';
	return WC_Crackcha::insertCrackord(
		$chall,
		GWF_Session::getUserID(),
		GWF_Session::getOrDefault('WCC_CRACKCHA_START', 0),
		crackcha_elapsed(),
		GWF_Session::getOrDefault('WCC_CRACKCHA_SOLVED', 0),
		GWF_Session::getOrDefault('WCC_CRACKCHA_COUNT', 0)
	);
}

function crackcha_next(WC_Challenge $chall)
{
	if (crackcha_round_over()) {
		header('Content-Type: text/plain');
		if (false === crackcha_insert_high($chall)) {
			echo GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
			return;
		} else {
			echo $chall->lang('msg_insert_high').PHP_EOL;
			echo crackcha_reset($chall);
			return;
		}
	}
	
	require_once GWF_CORE_PATH.'inc/3p/Class_Captcha.php';
	$chars = GWF_Random::randomKey(5, GWF_Random::ALPHAUP);
	crackcha_increase_count();
	GWF_Session::set('WCC_CRACKCHA_CHARS', $chars);
	$aFonts = array(GWF_PATH.'extra/font/teen.ttf');
	$rgbcolor = GWF_CAPTCHA_COLOR_BG;
	$oVisualCaptcha = new PhpCaptcha($aFonts, 210, 42, $rgbcolor);
	$oVisualCaptcha->Create('', $chars);
}

function crackcha_answer(WC_Challenge $chall)
{
	if ('' === ($answer = Common::getGetString('answer', ''))) {
		echo $chall->lang('err_no_answer');
		return;
	}
	
	if (false === ($solution = GWF_Session::getOrDefault('WCC_CRACKCHA_CHARS', false))) {
		echo $chall->lang('err_no_problem');
		return;
	}
	
	if ($answer === $solution)
	{
		crackcha_increase_solved();
		
		echo $chall->lang('msg_success', array(GWF_Session::getOrDefault('WCC_CRACKCHA_SOLVED', 0), WCC_CRACKCHA_NEED));
		
		if (crackcha_solved())
		{
			GWF_Module::loadModuleDB('Forum', true, true);
			Module_WeChall::includeForums();
			$chall->onChallengeSolved(GWF_Session::getUserID());
		}
	}
	else
	{
		echo $chall->lang('msg_failed', array($answer, $solution));
	}
	
	GWF_Session::remove('WCC_CRACKCHA_CHARS');
	
}

?>