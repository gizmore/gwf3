<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <seconds> <the message to alert>. Make %BOT% remember you of something in a specified amount of time.',
		'err_seconds' => 'Error in parsing your seconds. Seconds have to be larger or equal to 1. Try 1h13m37s.',
		'msg_remember' => 'Ok, i will remember you in %s.',
		'err_too_long' => 'This would take too long. Try 2d15m37s',
		'err_too_much' => 'You have exhausted your alert slots.',
	),
);
global $DOG_PLUG_ALERT_TIMERS;
if (!isset($DOG_PLUG_ALERT_TIMERS)) $DOG_PLUG_ALERT_TIMERS = array();

$plug = Dog::getPlugin();

if ($plug->argc() < 2)
{
	return $plug->showHelp();
}

$seconds = str_replace('m', 'i', $plug->argv(0));

// Try to parse seconds from input
if (0 >= ($seconds = GWF_TimeConvert::humanToSeconds($seconds)))
{
	return $plug->rply('err_seconds');
}
if ((GWF_Time::ONE_DAY*8) < $seconds)
{
	return $plug->rply('err_too_long');
}

// Try to parse back duration from parsed seconds
if (false === ($delay = GWF_TimeConvert::humanDurationISO(Dog::getLangISO(), $seconds)))
{
	return $plug->rply('err_seconds');
}

$user = Dog::getUser();
if (!isset($DOG_PLUG_ALERT_TIMERS[$user->getID()])) { $DOG_PLUG_ALERT_TIMERS[$user->getID()] = 0; }

if ($DOG_PLUG_ALERT_TIMERS[$user->getID()] >= 3)
{
	return $plug->rply('err_too_much');
}




if (!function_exists('dog_plugin_alert_func4'))
{
	function dog_plugin_alert_func4(array $args)
	{
		global $DOG_PLUG_ALERT_TIMERS;
		$scope = $args[0];
		$scope instanceof Dog_Scope;
		Dog::setScope($scope);
		Dog::reply($args[1]);
		$DOG_PLUG_ALERT_TIMERS[$scope->getUser()->getID()]--;
		
	}
}


Dog_Timer::addTimer('dog_plugin_alert_func4', array(Dog::getScope(), $plug->argvMsgFrom(1)), $seconds, false);
$DOG_PLUG_ALERT_TIMERS[$user->getID()]++;

$plug->rply('msg_remember', array($delay));
