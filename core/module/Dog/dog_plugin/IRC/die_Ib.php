<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<message here>]. Make the bot quit forever.',
		'default' => '%s issued the die command.',
	),
);
$plugin = Dog::getPlugin();
$message = $plugin->argc() === 0 ? $plugin->lang('default', array(Dog::getUser()->displayName())) : $plugin->msg();
Dog_Launcher::kill();
foreach (Dog::getServers() as $server)
{
	$server instanceof Dog_Server;
	if ($server->isConnected())
	{
		$server->getConnection()->disconnect($message);
	}
}
?>
