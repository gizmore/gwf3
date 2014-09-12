<?php
$command = 'echo "`whoami`@`hostname`';
$whoami = $command.' # %s';
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Shows the output of the following linux command: '.$command,
		'whomi' => $whoami,
	),
	'en' => array(
		'help' => 'Nutze: %CMD%. Führt diesen linux Befehl aus: echo "`whoami`@`hostname`',
		'whomi' => $whoami,
	),
);

if (!function_exists('exec'))
{
	return Dog::rply('err_exec');
}

$plugin = Dog::getPlugin();
$user = Dog::getUser();
$output = array();
exec($command, $output);
$plugin->reply(implode("\t ", $output));

