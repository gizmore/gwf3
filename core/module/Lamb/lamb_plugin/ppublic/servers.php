<?php # Usage: %CMD% <id|name>. Show info about a server.
if ($message === '')
{
	if (false === ($result = $server->select('serv_id, serv_host, serv_flood_amt', '', 'serv_id ASC')))
	{
		$bot->reply('Database error!');
		return;
	}
	$out = '';
	$servercount = 0;
	while (false !== ($s = $server->fetch($result, GDO::ARRAY_N)))
	{
		$servercount++;
		$b = $s[2] >= 4 ? chr(2) : '';
		$throttle = $s[2] == 0 ? '' : "({$b}T{$s[2]}{$b})";
		$b = $bot->getServer($s[0]) === false ? '' : chr(2);
		$b2 = $s[2] == 0 ? chr(2) : '';
		$out .= sprintf(", {$b}%s{$b}-{$b2}%s{$b2}%s", $s[0], Common::getTLD($s[1]), $throttle);
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