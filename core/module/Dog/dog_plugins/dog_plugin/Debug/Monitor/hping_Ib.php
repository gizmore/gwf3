<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <host>. Use the ping command to ping a host.',
		'err_host' => 'The host looks invalid.',
	),
);

$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc !== 1)
{
	return $plugin->showHelp();
}

$host = $argv[0];

if (!preg_match('/^[a-z0-9\.\-:]+$/iD', $host))
{
	$plugin->rply('err_host');
}

elseif (!function_exists('exec'))
{
	Dog::rply('err_exec');
}

else
{
	$ehost = escapeshellarg($host);
	exec("ping -c 3 $ehost", $output);
	foreach ($output as $line)
	{
		Dog::reply($line);
	}
}
?>
