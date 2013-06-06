<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show the botflagged users in this channel.',
		'bots' => '%s bots: %s. And me!',
		'nobots' => 'There are no bots here beside me.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD%. Zeige alle User mit einem Botflag in diesem Kanal.',
		'bots' => '%s Bots: %s. Und ich!',
		'nobots' => 'Es gibt hier keine Bots ausser mir.',
	),
);
$plugin = Dog::getPlugin();
$channel = Dog::getChannel();

$names = array();
foreach ($channel->getUsers() as $user)
{
	$user instanceof Dog_User;
	if ($user->isBot())
	{
		$names[] = $user->getName();
	}
}

$count = count($names);
if ($count === 0)
{
	$plugin->rply('nobots');
}
else
{
	$plugin->rply('bots', array($count, GWF_Array::implodeHuman($names)));
}