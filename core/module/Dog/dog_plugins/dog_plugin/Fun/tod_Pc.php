<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [rules]. Truth or dare 2.0.',
		'rules' => 'Truth or Dare v2.0. Dice until a valid match is found. Truth == answer in channel, Dare == execute a shell command and paste results.',
		'round' => '%s is asking you, %s: "Truth or dare!". See .tud rules for rules.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% [regeln]. Wahrheit oder Pflicht 2.0.',
		'rules' => 'Wahrheit oder Pflicht v2.0. Würfel bis ein gültiges Pärchen gefunden wurde. Wahrheit == Im channel antworten. Pflicht == Einen Shell Befehl ausführen und Ergebnis pasten.',
		'round' => '%s fragt dich, %s: "Wahrheit oder Pflicht!". Nutze .tud regeln um die Regeln einzusehen.',
	),
);


$plug = Dog::getPlugin();
$serv = Dog::getServer();
$chan = Dog::getChannel();

$argv = $plug->argv();
$argc = $plug->argc();

if ($argc > 1)
{
	return $plug->showHelp();
}
elseif ($argc === 1)
{
	return $plug->rply('rules');
}

$players = array();
foreach ($chan->getUsers() as $u)
{
	$u instanceof Dog_User;
// 	if (Dog::hasChanPermission($serv, $chan, $user, 'l'))
	{
		$players[] = $u;
	}
}

$player = GWF_Random::arrayItem($players); $player instanceof Dog_User;
$victim = GWF_Random::arrayItem($players); $victim instanceof Dog_User;

$plug->rply('round', array($player->displayName(), $victim->displayName()));
