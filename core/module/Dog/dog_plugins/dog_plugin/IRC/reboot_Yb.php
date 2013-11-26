<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<message here...>]. Initiate a reboot and quit with a message.',
		'default' => '%s is rebooting me :O',
	),
);
// GWF_HTTP::getFromURL("")

return Dog::reply('YOU FOUND A TODO!');

$plugin = Dog::getPlugin();
$message = $plugin->argc() === 0 ? $plugin->lang('default', array(Dog::getUser()->displayName())) : $plugin->msg();
foreach (Dog::getServers() as $server)
{
	$server instanceof Dog_Server;
	$server->disconnect($message);
}
Dog_Launcher::kill();
?>
