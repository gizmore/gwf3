<?php
/**
 * Holds a timer that tries to reclaim nickname.
 * @author gizmore
 */
final class DOGMOD_ClaimNick extends Dog_Module
{
	public function onInitTimers()
	{
		Dog_Timer::addTimer(array($this, 'claim'), null, 120);
	}
	
	public function claim()
	{
		foreach (Dog::getServers() as $server)
		{
			$server instanceof Dog_Server;
			if ($this->isEnabled($server, false) && $server->isConnected())
			{
				$this->claimServer($server);
			}
		}
	}

	public function claimServer(Dog_Server $server)
	{
		if ($server->getNick()->isTemp())
		{
			if (false !== ($nick = Dog_Nick::getNickFor($server)))
			{
				$server->sendRAW("NICK {$nick->getName()}");
			}
		}
	}
}
