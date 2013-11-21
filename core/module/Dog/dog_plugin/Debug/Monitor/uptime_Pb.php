<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Print statistics about the bots uptime.',
		'out' => 'This bot is running since %s. Total runtime: %s.',
	),
);
$plugin = Dog::getPlugin();

if ($plugin->argc() > 0)
{
	$plugin->showHelp();
}

else
{
	$uptime = round(Dog_Init::getUptime());
	$total = GWF_Counter::getCount('dog_uptime') + $uptime;
	$plugin->rply('out', array(GWF_Time::humanDuration($uptime), GWF_Time::humanDuration($total)));
}
