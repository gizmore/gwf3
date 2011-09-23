<?php
if (stripos($from, 'NickServ!') === 0)
{
	echo $args[1].PHP_EOL;
	echo "1\n";
	if (preg_match('/^STATUS ([^ ]+) ([0-9])$/D', $args[1], $matches))
	{
		$nickname = $matches[1];
		echo "2 $nickname\n";
		
		# Probe
		if ( ($nickname === $server->getBotsNickname()) && (($matches[2]==='0') || ($matches[2]==='3')) )
		{
			echo "--- Has status!\n";
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