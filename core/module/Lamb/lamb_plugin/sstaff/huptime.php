<?php # Usage: %CMD%. Show the result of the unix uptime command. Requires dangerous php functions to work.
if (!function_exists('exec'))
{
	$bot->reply('The exec function is disabled. A workaround using a different approach is unknown to guessmo.');
	return;
}
$output = array();
exec("uptime", $output);
$bot->reply($output[0]);
?>