<?php # Usage: %TRIGGER%hping <host>. Ping a target server.
$host = Common::substrUntil($message, ' ', $message);
if (!preg_match('/^[a-z0-9\.\-]+$/i', $host)) {
	$bot->reply('The host looks invalid.');
	return;
}
if (!function_exists('exec'))
{
	$bot->reply('The exec function is disabled. A workaround would be the pear ping extension.');
	return;
}

$ehost = escapeshellarg($host);
exec("ping -c 3 $ehost", $output);
$output = implode(PHP_EOL, $output);

if (stripos($output, 'unknown host') !== false)
{
	$bot->reply('Unknown host: '.$host);
	return;
}

if (!preg_match('/\\(([0-9\.]+)\\)/', $output, $ip)) {
	$bot->reply('Can not parse IP for host '.$host);
	echo $output.PHP_EOL;
	return;
}

if (!preg_match('/([0-9\.]+)\\/([0-9\.]+)\\/([0-9\.]+)\//', $output, $timing)) {
	$bot->reply('Can not find timings for the pings. It probably failed!');
	echo $output.PHP_EOL;
	return;
}

$ip = $ip[1];
$min = $timing[1];
$avg = $timing[2];
$max = $timing[3];

$bot->reply("Ping to $host($ip) took {$avg}ms in average.");
?>
