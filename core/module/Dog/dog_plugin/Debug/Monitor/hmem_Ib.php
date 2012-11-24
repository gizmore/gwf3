<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show the result of the unix free command. Requires dangerous php functions to work.',
	),
);

$plugin = Dog::getPlugin();

if (!function_exists('exec'))
{
	return Dog::rply('err_exec');
}

$user = Dog::getUser();
$output = array();
exec("free -m", $output);
foreach ($output as $line)
{
	$user->sendNOTICE($line);
}
?>
