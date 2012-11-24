<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Print info about the mode bits and which you got in the current target.',
		'in_chan' => 'Your permissions in %s: %s.',
		'on_serv' => 'Your permissions on %s: %s.',
	),
);

$plugin = Dog::getPlugin();
$chan = Dog::getChannel();
$serv = Dog::getServer();
$user = Dog::getUser();

$out = '';
foreach (Dog_IRCPriv::$CHARMAP as $priv)
{
	$b = Dog::hasPermission($serv, $chan, $user, $priv) ? chr(2) : '';
	$out .= sprintf(', %s%s%s', $b, Dog_IRCPriv::displayChar($priv), $b);
}

$out = substr($out, 2);

if ($chan === false)
{
	$plugin->rply('in_chan', array($chan->displayName(), $out));
}
else
{
	$plugin->rply('on_serv', array($serv->displayName(), $out));
}
?>
