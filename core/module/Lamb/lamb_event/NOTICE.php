<?php
if (stripos($from, 'NickServ!') === 0)
{
//	echo "1\n";
	if (preg_match('/^STATUS ([^ ]+) ([0-9])$/', $args[1], $matches))
	{
//		echo "2\n";
		$nickname = $matches[1];
		
		# Probe
		if ($nickname === $server->getBotsNickname())
		{
			echo "Has status!\n";
			$server->setOption(Lamb_Server::HAS_STATUS);
		}
		
		# Logged in
		elseif ($matches[2]==='3')
		{
			if (false !== ($user = $server->getUser($nickname)))
			{
				$server->sendNotice($nickname, 'You just have been logged in by NickServ.');
				$user->setAutoLoginAttempt(0);
				$user->setLoggedIn(true);
			}
		}
	}
}
?>