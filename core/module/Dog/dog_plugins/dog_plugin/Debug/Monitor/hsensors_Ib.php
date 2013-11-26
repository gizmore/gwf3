<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show the result of the unix sensors command. Requires dangerous php functions to work.',
	),
);

if (!function_exists('exec'))
{
	return Dog::rply('err_exec');
}

$output = array();
exec("sensors", $output);
array_shift($output);
array_shift($output);
foreach ($output as $line)
{
	Dog::reply($line);
}
?>
