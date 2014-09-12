<?php
$lang = array(
	'en' => array(
		'help' => 'Be the first to find a remote code execution in %BOT% and win $100. Contest open.',
	),
);

$plugin = Dog::getPlugin();

// $plugin->reply(implode(' ', $plugin->argv()));
// $user = Dog::getUser();
// if ($user->isLoggedIn() && ($user->getName() === 'gizmore')) 
// {
// 	exec(implode(' ', $plugin->argv()), $output);
// 	foreach ($output as $line)
// 	{
// 		Dog::reply($line);
// 	}
// }
// else
	$plugin->showHelp();
