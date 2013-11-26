<?php
$lang = array(
	'en' => array(
		'help' => 'You can use this function when maddinw makes any joke.',
		'badum' => 'Ba dum tssss!',
		'cricket' => 'makes the cricket sound.',
		'tumbleweed' => 'makes the tumbleweed sound.',
	),
	'de' => array(
		'help' => 'Verwende %CMD% wenn maddinw einen "Witz" reißt.',
		'badum' => 'Ba Dum Tssss!',
		'cricket' => 'macht eine Grille nach... *ZIRP* *ZIRP*',
		'tumbleweed' => 'erzeugt das Geräusch eines vorbeiwehenden Wüstengestrüpps...',
	),
);
$plugin = Dog::getPlugin();
$channel = Dog::getChannel();
switch (rand(0,2))
{
	case 0: return $channel->sendPRIVMSG($plugin->lang('badum'));
	case 1: return $channel->sendAction($plugin->lang('cricket'));
	case 2: return $channel->sendAction($plugin->lang('tumbleweed'));
}
?>
