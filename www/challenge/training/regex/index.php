<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Training: Regex');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle('Training: Regex'))) {
	$chall = WC_Challenge::dummyChallenge('Training: Regex', 2, '/challenge/training/regex/index.php', false);
}
$chall->showHeader();

$level = GWF_Session::getOrDefault('WCC_T_REGEX', 1);

if (false !== ($answer = Common::getPost('answer')))
{
	$function = 'train_regex_level_'.$level;

	# Users can cause errors... don`t die :) (thx busyr
	GWF_Debug::setMailOnError(false);
	GWF_Debug::setDieOnError(false);
	$solved = call_user_func($function, $chall, $answer);
	GWF_Debug::setMailOnError(true);
	GWF_Debug::setDieOnError(true);
	
	if ($solved === true)
	{
		$level++;
		$next_func = 'train_regex_level_'.$level;
		if (!function_exists($next_func)) {
			echo GWF_HTML::message('WeChall', $chall->lang('msg_solved'), false);
			$chall->onChallengeSolved(GWF_Session::getUserID());
			$level = 1;
		}
		else {
			echo GWF_HTML::message('WeChall', $chall->lang('msg_next_level'), false);
		}
		
		GWF_Session::set('WCC_T_REGEX', $level);
	}
	else
	{
		echo GWF_HTML::error('WeChall', $chall->lang('err_wrong'), false);
	}
}

echo GWF_Box::box($chall->lang('info_'.$level), $chall->lang('title', array($level)));

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

##########
# Levels #
##########
function train_regex_level_1(WC_Challenge $chall, $answer)
{
	if ($answer === '/^$/')
	{
		return true;
		# It does match \n
		echo GWF_HTML::error('WeChall', $chall->lang('err_matching', array('\\n')), false);
		return false;
	}
	
	# Thx ludde!
	return ($answer === '/^$/D') || ($answer === '/^\z/');
}

function train_regex_level_2(WC_Challenge $chall, $answer)
{
	return $answer === '/^wechall$/';
}

function train_regex_level_3(WC_Challenge $chall, $answer)
{
	$solution = '/^wechall4?\.(?:jpg|gif|tiff|bmp|png)$/';
	$samples_good = array('wechall.jpg', 'wechall.gif', 'wechall.tiff', 'wechall.bmp', 'wechall.png', 'wechall4.jpg', 'wechall4.gif', 'wechall4.tiff', 'wechall4.bmp', 'wechall4.png');
	$samples_bad = array('wechall', 'wechall4', 'wechall3.png', 'wechall4.jpf', 'wechallpng', 'wechallxjpg', 'wechall.jpg ', ' wechall.jpg', 'mechall.jpg', 'meechll.jpg');
	
	foreach ($samples_good as $t)
	{
		if (!preg_match($answer, $t, $matches))
		{
			echo GWF_HTML::error('WeChall', $chall->lang('err_no_match', array($t)), false);
			return false;
		}
		if (count($matches) !== 1)
		{
			echo GWF_HTML::error('WeChall', $chall->lang('err_capturing'), false);
			return false;
		}
	}
	
	foreach ($samples_bad as $t)
	{
		if (preg_match($answer, $t, $matches))
		{
			echo GWF_HTML::error('WeChall', $chall->lang('err_matching', array($t)), false);
			return false;
		}
	}
	
	if (strlen($answer) > strlen($solution)) {
		echo GWF_HTML::error('WeChall', $chall->lang('err_too_long', array(strlen($solution))), false);
		return false;
	}
	
	return true;
}

function train_regex_level_4(WC_Challenge $chall, $answer)
{
	$solution = '/^(wechall4?)\.(?:jpg|gif|tiff|bmp|png)$/';
	$samples_good = array('wechall.jpg', 'wechall.gif', 'wechall.tiff', 'wechall.bmp', 'wechall.png', 'wechall4.jpg', 'wechall4.gif', 'wechall4.tiff', 'wechall4.bmp', 'wechall4.png');
	$samples_bad = array('wechall', 'wechall4', 'wechall3.png', 'wechall4.jpf', 'wechallpng', 'wechallxjpg', 'wechall.jpg ', ' wechall.jpg', 'mechall.jpg', 'meechll.jpg');
	
	foreach ($samples_good as $t)
	{
		if (!preg_match($answer, $t, $matches))
		{
			echo GWF_HTML::error('WeChall', $chall->lang('err_no_match', array($t)), false);
			return false;
		}
		
		$filename = Common::substrUntil($t, '.');
		
		if ( (count($matches) !== 2) || ($filename !== $matches[1]) )
		{
			echo GWF_HTML::error('WeChall', $chall->lang('err_not_capturing'), false);
			return false;
		}
	}
	
	foreach ($samples_bad as $t)
	{
		if (preg_match($answer, $t, $matches))
		{
			echo GWF_HTML::error('WeChall', $chall->lang('err_matching', $t), false);
			return false;
		}
	}
	
	if (strlen($answer) > strlen($solution)) {
		echo GWF_HTML::error('WeChall', $chall->lang('err_too_long', array(strlen($solution))), false);
		return false;
	}
	
	return true;
}

//function train_regex_level_5(WC_Challenge $chall, $answer)
//{
//	echo 'LEVEL NOT WORKING YET';
//	return false;
//}
?>