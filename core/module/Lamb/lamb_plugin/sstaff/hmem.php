<?php # Usage: %CMD%. Show the result of the unix free command. Requires dangerous php functions to work.
if (!function_exists('exec'))
{
	$bot->reply('The exec function is disabled. A workaround using a different approach is unknown to guessmo.');
	return;
}

$bot instanceof Lamb;
$server instanceof Lamb_Server;
$user = $bot->getCurrentUser();

$output = array();
exec("free -m", $output);
foreach ($output as $line)
{
//	$bot->reply($line);
	$server->sendNotice($user->getName(), $line);
}
?>