<?php # Usage: %TRIGGER%server_info <id|name>. Show info about a server.
if ($message === '')
{
	$db = gdo_db();
	$table = GWF_TABLE_PREFIX.'lamb_server';
	$query = "SELECT serv_id, serv_name FROM $table ORDER BY serv_id ASC";
	if (false === ($result = $db->queryRead($query))) {
		$bot->reply('Database error!');
		return;
	}
	
	$out = '';
	$servercount = 0;
	while (false !== ($s = $db->fetchRow($result)))
	{
		$servercount++;
		$out .= sprintf(', %s(%s)', Common::getTLD($s[1]), $s[0]);
	}
	$db->free($result);
	
	$out = sprintf('%s server(s) in the database: %s.', $servercount, substr($out, 2));
	$bot->reply($out);
	return;
} 
if (is_numeric($message))
{
	if (false === ($s = Lamb_Server::getByID($message))) {
		$bot->reply('This server is unknown.');
		return;
	}
}
else
{
	if (false === ($s = Lamb_Server::getByHost($message))) {
		$bot->reply('This server is unknown.');
		return;
	}
}

$s instanceof Lamb_Server;
$id = $s->getID();
$name = $s->getName();
$port = $s->getPort();
$ssl = $s->isSSL() ? ' (SSL)' : '';
$ip = $s->getIP();
$maxu = $s->getMaxUsers();
$maxc = $s->getMaxChannels();
$b = chr(2);
$bot->reply(sprintf("Server %s - $b%s$b:%s%s (%s) - Maxusers: %s, Maxchans: %s", $id, $name, $port, $ssl, $ip, $maxu, $maxc));
?>