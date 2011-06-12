<?php # Usage: %CMD% <id|name>. Show info about a server.
$b = chr(2);
if ($message === '')
{
	if (false === ($result = $server->select('serv_id, serv_host', '', 'serv_id ASC')))
	{
		$bot->reply('Database error!');
		return;
	}
	$out = '';
	$servercount = 0;
	while (false !== ($s = $server->fetch($result, GDO::ARRAY_N)))
	{
		$servercount++;
		$out .= sprintf(", {$b}%s{$b}-%s", $s[0], Common::getTLD($s[1]));
	}
	$server->free($result);
	
	$out = sprintf('%s server(s) in the database: %s.', $servercount, substr($out, 2));
	$bot->reply($out);
	
	return;
} 

if (is_numeric($message))
{
	if (false === ($s = Lamb_Server::getByID($message)))
	{
		$bot->reply('This server is unknown.');
		return;
	}
}
else
{
	if (false === ($s = Lamb_Server::getByHost($message)))
	{
		$bot->reply('This server is unknown.');
		return;
	}
}

$id = $s->getID();
$s2 = Lamb::instance()->getServer($id);

$name = $s->getHostname();
$port = $s->getPort();
$ssl = $s->isSSL() ? ' (SSL)' : '';
$ip = $s->getIP();
$maxu = $s->getMaxUsers();
$maxc = $s->getMaxChannels();
$version = $s->getVar('serv_version');
//$online = $s->isOnline() ? " \x02(up)\x02" : '';
$online = ($s2 !== false) && ($s2->isOnline()) ? " \x02(up)\x02" : '';
$bot->reply(sprintf("Server %s-$b%s$b:%s%s (IP: %s) (IRCD: %s)%s - Maxusers: %s, Maxchans: %s.", $id, $name, $port, $ssl, $ip, $version, $online, $maxu, $maxc));
?>