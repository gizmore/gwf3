<?php # %EVENT% Version, Channel- and Usermodes.
# :irc.giz.org 004 Lamb3 irc.giz.org Unreal3.2.8.1 iowghraAsORTVSxNCWqBzvdHtGp lvhopsmntikrRcaqOALQbSeIKVfMCuzNTGj

$server instanceof Lamb_Server;

if (count($args) === 5)
{
	list($bots_nickname, $hostname, $version, $chanmodes, $usermodes) = $args;
	$foomodes = '';
}
elseif (count($args) === 6)
{
	list($bots_nickname, $hostname, $version, $chanmodes, $usermodes, $foomodes) = $args;
}
else
{
	var_dump($args);
	return Lamb_Log::logError('004: argc is not 5 or 6: '.implode(', ', $args));
}

if (false === $server->saveVars(array(
	'serv_version' => $version,
	'serv_chanmodes' => $chanmodes,
	'serv_usermodes' => $usermodes,
)))
{
	return Lamb_Log::logError('Database error!');
}

Lamb_Log::logDebug(sprintf("Setting server %s-%s to IRCD=%s  C=%s  U=%s", $server->getID(), $server->getHostname(), $version, $chanmodes, $usermodes));

?>
