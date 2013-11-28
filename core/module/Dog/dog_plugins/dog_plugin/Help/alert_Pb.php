<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <seconds> <the message to alert>. Make %BOT% remember you of something in a specified amount of time.',
		'err_seconds' => 'Error in parsing your seconds. Try 1h13m37s.',
		'msg_remember' => 'Ok, i will remember you in %s.',
	),
);
# TODO: Remember active alerts and restrict to max count per user (1-3)
// global $DOG_PLUG_ALERT_TIMERS;
// if (!isset($DOG_PLUG_ALERT_TIMERS)) $DOG_PLUG_ALERT_TIMERS = array();

$plug = Dog::getPlugin();

if ($plug->argc() < 2)
{
	return $plug->showHelp();
}

// Try to parse seconds from input
if (0 === ($seconds = GWF_TimeConvert::humanToSeconds($plug->argv(0))))
{
	return $plug->rply('err_seconds');
}
// Try to parse back duration from parsed seconds
if (false === ($delay = GWF_TimeConvert::humanDurationISO(Dog::getLangISO(), $seconds)))
{
	return $plug->rply('err_seconds');
}

if (!function_exists('dog_plugin_alert_func'))
{
	function dog_plugin_alert_func(array $args)
	{
// 		global $DOG_ALERT_TIMERS;
		Dog::setScope($args[0]);
		Dog::reply($args[1]);
	}
}


Dog_Timer::addTimer('dog_plugin_alert_func', array(Dog::getScope(), $plug->argvMsgFrom(1)), $seconds, false);

$plug->rply('msg_remember', array($delay));
