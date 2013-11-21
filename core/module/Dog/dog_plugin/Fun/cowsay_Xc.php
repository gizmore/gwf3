<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <message here>.',
	),
);
$plugin = Dog::getPlugin();
$chan = Dog::getChannel();
if (!function_exists('exec'))
{
	return Dog::rply('err_exec');
}
if ('' === ($msg = $plugin->msg()))
{
	return $plugin->showHelp();
}
$output = array();
$msg = escapeshellarg($msg);
exec("cowsay -f cat -- $msg", $output);
foreach ($output as $line)
{
	$chan->sendPRIVMSG($line);
}
