<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show the result of the unix uptime command. Requires dangerous php functions to work.',
	),
);

if (!function_exists('exec'))
{
	return Dog::rply('err_exec');
}

$output = array();
exec("uptime", $output);
Dog::reply($output[0]);
?>
