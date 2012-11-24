<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <raw irc data here>. Send raw IRC data to this server.',
	),
);
$plugin = Dog::getPlugin();

if ('' === ($message = $plugin->msg()))
{
	$plugin->showHelp();
}
else
{
	Dog::getServer()->sendRAW($message);
}
?>
