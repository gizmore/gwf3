<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Works only inside a channel and will try to lift your status.',
		'no_privs' => 'I have not enough privileges in that channel.',
		'yours_better' => 'Your privileges are even higher than mine :O',
	),
	'de' => array(
		'help' => 'Nutze: %CMD%. Funktioniert nur in Kanälen und erhöht deinen IRC Status.',
		'no_privs' => 'Meine Rechte reichen hier nicht aus.',
		'yours_better' => 'Deine Rechte sind ja höher als meine ^^',
	),
);

$user = Dog::getUser();
$plugin = Dog::getPlugin();
$server = Dog::getServer();

if (false === ($channel = Dog::getChannel()))
{
	return Dog::rply('err_only_channel');
}

$dogprv = $channel->getPriv($channel->getDog());
$dogbit = Dog_IRCPriv::charsToBits($dogprv);
$bit = Dog_PrivChannel::getPermbits($channel, $user);

echo "ME HAS $dogprv === $dogbit\n";
echo "HE HAS $bit\n";

if ($dogbit < Dog_IRCPriv::charsToBits('h'))
{
	$plugin->rply('no_privs');
}

elseif ($bit > $dogbit)
{
	$plugin->rply('yours_better');
}

elseif ($dogbit > $bit)
{
	$server->getConnection()->sendRAW(sprintf('MODE %s +%s %s', $channel->getName(), Dog_IRCPriv::bitToBestNamedSymbol($dogbit), $user->getName()));
}
?>
