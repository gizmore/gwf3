<?php
$lang = array(
	'en' => array(
		'help' => '%CMD% <global message here>. Send a message to all channels. Do not use!',
		'bark' => 'barks: "%s"',
	),
);

$plugin = Dog::getPlugin();

if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}

foreach (Dog::getServers() as $server)
{
	$server instanceof Dog_Server;
	foreach ($server->getChannels() as $channel)
	{
		$channel instanceof Dog_Channel;
		$channel->sendAction($plugin->langISO($channel->getLangISO(), 'bark', array($message)));
	}
}
