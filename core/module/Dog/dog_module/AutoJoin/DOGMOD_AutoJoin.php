<?php
/**
 * This module automatically joins channels and allows to control the autojoin bit.
 * Additionally it features kickjoin settings on a per channel basis.
 * @author gizmore
 */
final class DOGMOD_AutoJoin extends Dog_Module
{
	public function getOptions()
	{
		return array(
			'kickjoin' => 'c,s,b,0', # channel staff boolean false, 
		);
	}

	public function event_001()
	{
		$server = Dog::getServer();
		$sid = $server->getID();
		
		$table = GDO::table('Dog_Channel');
		if (false === ($result = $table->select('*', "chan_sid={$sid} AND chan_options&".Dog_Channel::AUTO_JOIN)))
		{
			return;
		}
		
		while (false !== ($channel = $table->fetch($result, GDO::ARRAY_O)))
		{
			$channel instanceof Dog_Channel;
			$server->joinChannel($channel);
		}
		
		$table->free($result);
	}
	
	/**
	 * Rejoin on kick :)
	 */
	public function event_KICK()
	{
		$server = Dog::getServer();
		if (Dog::argv(1) === $server->getNick()->getName())
		{
			if ($this->getConfig('kickjoin'))
			{
				$server->joinChannel(Dog::getChannel());
			}
		}
	}
	
	public function on_autojoin_Ia()
	{
		$argv = $this->argv();
		$argc = count($argv);
		
		if  ( ($argc === 0)
			||(false === ($channel = Dog::getOrLoadChannelByArg($argv[0]))) )
		{
			return Dog::rply('err_channel');
		}
		
		switch ($argc)
		{
			# privmsg .autojoin #wechall (show bit for a channel)
			case 1:
				return $this->showStatus($channel);
		
			# privmsg .autojoin #wechall off (set bit for a channel)
			case 2:
				if (!Dog_Var::isValid('b', $argv[1]))
				{
					return Dog::rply('err_variabl', array($this->getName(), 'autojoin', Dog_Var::displayType('b')));
				}
				return $this->setEnabled($channel, Dog_Var::parseValue('b', $argv[1]));
		}
		
		$this->showHelp('autojoin');
	}
	
	public function on_autojoin_Ac()
	{
		$user = Dog::getUser();
		$server = Dog::getServer();
		
		$argv = $this->argv();
		$argc = count($argv);
		
		# Invoked in channel.
		switch ($argc)
		{
			# .autojoin
			case 0: return $this->showStatus($channel);
		
			# .autojoin on|#channel
			case 1:
			
				if (Dog_Var::isValid('b', $argv[0]))
				{
					return $this->setEnabled($channel, Dog_Var::parseValue('b', $argv[0]));
				}
				elseif (false === ($channel = Dog::getOrLoadChannelByArg($argv[0])))
				{
					return Dog::rply('err_channel');
				}
				else 
				{
					return $this->showStatus($channel);
				}
				
			# .autojoin #wechall on
			case 2:

				if (false === ($channel = Dog::getOrLoadChannelByArg($argv[0])))
				{
					return Dog::rply('err_channel');
				}
					
				if (!Dog::hasPermission($server, $channel, $user, 'A'))
				{
					return Dog::noPermission('s');
				}

				return $this->setEnabled($channel, Dog_Var::parseValue('b', $argv[1]));
		}
		
		$this->showHelp('autojoin');
	}
	
	private function showStatus(Dog_Channel $channel)
	{
		$key = $channel->isOptionEnabled(Dog_Channel::AUTO_JOIN) ? 'is_on' : 'is_off';
		return $this->rply($key, array($channel->displayName()));
	}
	
	private function setEnabled(Dog_Channel $channel, $value)
	{
		$channel->saveOption(Dog_Channel::AUTO_JOIN, $value);
		$key = $value ? 'enabled' : 'disabled';
		return $this->rply($key, array($channel->displayName()));
	}
}
