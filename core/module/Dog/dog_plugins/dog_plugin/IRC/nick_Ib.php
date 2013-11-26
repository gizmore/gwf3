<?php
$lang = array(
	'en' => array(
		'help' => '%CMD% <nickname>. Change the bot`s nickname.',
		'curr' => 'My current nick here is %s.',
		'ok' => 'Sending the NICK command...',
	),
);
$plugin = Dog::getPlugin();

$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 0)
{
	$plugin->rply('curr', array(Dog::getNickname()));
}

elseif ( ($argc === 1) && (preg_match('/^[a-z0-9_]+$/i', $argv[0])) )
{
	$plugin->rply('ok');
	Dog::getServer()->sendRAW("NICK {$argv[0]}");
}

else
{
	$plugin->showHelp();
}
?>
