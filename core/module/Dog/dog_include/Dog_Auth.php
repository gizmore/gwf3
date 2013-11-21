<?php
final class Dog_Auth
{
	public static function connect(Dog_Server $server)
	{
		if (false === ($nick = self::getNickData($server)))
		{
			return Dog_Log::warn(sprintf('No nicks for %s.', $server->displayName()));
		}
		
		$server->addUser(Dog::getOrCreateUserByName($nick->getName()));
		
		$conn = $server->getConnection();
		
		return
			self::sendUser($conn, $server, $nick)
			&& self::sendNick($conn, $server, $nick);
	}
	
	private static function getNickData(Dog_Server $server)
	{
		if (false === ($nick = Dog_Nick::getNickFor($server, $server->getIncreaseNicknum())))
		{
			return false; // TODO: Random nick
		}
		$server->setNick($nick);
		return $nick;
	}

	private static function sendUser(Dog_IRC $conn, Dog_Server $server, Dog_Nick $nick)
	{
		return $conn->send(sprintf('USER %s %s %s :%s', $nick->getUsername(), $nick->getHostname(), $server->getHost(), $nick->getRealname()));
	}
	
	private static function sendNick(Dog_IRC $conn, Dog_Server $server, Dog_Nick $nick)
	{
		if (!$conn->send("NICK {$nick->getName()}"))
		{
			return false;
		}
		
		if (NULL !== ($pass = $nick->getPass()))
		{
			if ($server->isBNC())
			{
				return $conn->send('PASS '.$pass);
			}
			else
			{
				return $server->sendPRIVMSG('NickServ', 'IDENTIFY '.$pass);
			}
		}
		return true;
	}
}
?>
