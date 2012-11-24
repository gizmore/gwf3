<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Restart all timers.',
		'ok' => 'Timers have been successfully flushed. %BOT% is sleeping for %d milliseconds each loop.',
	),
);
$millis = Dog_Init::getSleepMillis();
Dog_Timer::flush();
Dog_Timer::init(Dog_Init::getSleepMillis());
Dog_Init::initTimers();
Dog::rply('ok', array($millis));
?>
