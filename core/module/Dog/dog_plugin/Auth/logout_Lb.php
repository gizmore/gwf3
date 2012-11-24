<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Logs you out. Who actually wants that?!(demo plugin)',
		'not_in' => 'You are not logged in!',
		'out' => 'You are now logged out.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD%. Loggt dich aus. Wer will das schon... *rolleyes* (demo plugin)',
		'not_in' => 'Du bist nicht angemeldet!',
		'out' => 'Du bist nun abgemeldet!',
	),
);
$user = Dog::getUser();
$plugin = Dog::getPlugin();
if ($plugin->argc() !== 0)
{
	$plugin->showHelp();
}
elseif (!$user->isLoggedIn())
{
	$plugin->rply('not_in');
}
else
{
	$user->setLoggedIn(false);
	$plugin->rply('out');
}
?>
