<?php # Usage: %CMD% <host>. Ping a target server.
$host = Common::substrUntil($message, ' ', $message);
if (!preg_match('/^[a-z0-9\.\-]+$/iD', $host))
{
	$bot->reply('The host looks invalid.');
	return;
}
if (!function_exists('exec'))
{
	$bot->reply('The exec function is disabled. (good?)');
	return;
}

//$ehost = escapeshellarg($host);
//exec("ping -c 3 $ehost", $output);
exec("uptime", $output);

foreach ($output as $line)
{
	$bot->reply($line);
}
?>
