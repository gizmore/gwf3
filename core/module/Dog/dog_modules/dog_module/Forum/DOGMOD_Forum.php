<?php
require 'Dog_ForumAbbo.php';
require 'Dog_ForumEntry.php';

final class DOGMOD_Forum extends Dog_Module
{
	private static $CACHE = array();
	public static function refreshCache() { self::$CACHE = Dog_Forum::getCache(); }
	public function onInit() { self::refreshCache(); }
	public function onInitTimers() { Dog_Timer::addTimer(array($this, 'onTimer'), NULL, 60); }
	
	public function getOptions()
	{
		return array(
			'limit' => 'g,x,i,3',     # global owner integer 3 items
			'interval' => 'g,x,i,60', # global owner integer 60 seconds
			'boards' => 'c,a,x,""',   # channel admin script empty - which boards are linked
		);
	}
	
	public function configAbbos() { return Dog_Conf_Mod_Chan::getConf($this->getName(), Dog::getChannel()->getID(), 'boards', ''); }
	public function configSetAbbos($s) { return Dog_Conf_Mod_Chan::setConf($this->getName(), Dog::getChannel()->getID(), 'boards', $s); }
	public function on_ADDboard_Xb()
	{
		$argv = $this->argv();
		$argc = count($argv);
		
		if ($argc !== 2)
		{
			return $this->showHelp('+board');
		}

		if (false !== ($board = self::getBoard($argv[0]))) 
		{
			$board->saveOption(Dog_Forum::DELETED, false);
			return $this->rply('err_known', array($board->displayName()));
		}
		
		if (false === ($board = Dog_Forum::testBoard($argv[0], $argv[1])))
		{
			return $this->rply('err_response', array($argv[1]));
		}
		
		$board->insert();
		self::refreshCache();
		$this->rply('msg_added', array($board->displayName()));
	}
	
	public function on_REMOVEboard_Xb()
	{
		$argv = $this->argv();
		$argc = count($argv);
		
		if ($argc !== 1)
		{
			return $this->showHelp('-board');
		}
		
		if (false === ($board = self::getBoard($argv[0])))
		{
			return $this->rply('err_board');
		}
		
		$board->saveOption(Dog_Forum::DELETED, true);
		return $this->rply('msg_disabled', array($board->displayName()));
	}
	
	public function on_linkboard_Ac()
	{
		$argv = $this->argv();
		$argc = count($argv);
		if ( ($argc === 0) || ($argc > 3) )
		{
			return $this->showHelp('linkboard');
		}
		
		if (false === ($board = self::getBoard($argv[0])))
		{
			return $this->rply('err_board');
		}
		
		$bids = isset($argv[1]) ? $argv[1] : '0';
		$excl = isset($argv[2]) ? $argv[2] : '';
		
		$abbo = new Dog_ForumAbbo("{$board->getID()}:{$bids}:{$excl}");
		
		$abbos = Dog_ForumAbbo::explodeAbbos($this->configAbbos());
		
		if (Dog_ForumAbbo::containsAbbo($abbos, $abbo))
		{
			return $this->rply('err_already_linked', array($board->displayName()));
		}
		
		$abbos[] = $abbo;
		$this->saveAbbos($abbos);
		$this->rply('msg_linked', array($board->displayName()));
	}

	public function on_unlinkboard_Ac()
	{
		$argv = $this->argv();
		$argc = count($argv);
		if ($argc !== 1)
		{
			return $this->showHelp('unlinkboard');
		}
		
		if (false === ($board = self::getBoard($argv[0])))
		{
			return $this->rply('err_board');
		}
		$abbo = new Dog_ForumAbbo("{$board->getID()}:0:0");
		$abbos = Dog_ForumAbbo::explodeAbbos($this->configAbbos());
		if (!Dog_ForumAbbo::containsAbbo($abbos, $abbo))
		{
			return $this->rply('err_not_linked', array($board->displayName()));
		}
		foreach ($abbos as $i => $a)
		{
			$a instanceof Dog_ForumAbbo;
			if ($a->getForumID() === $abbo->getForumID())
			{
				unset($abbos[$i]);
			}
		}
		$this->saveAbbos($abbos);
		$this->rply('msg_unlinked', array($board->displayName()));
	}
	
	private function saveAbbos(array $abbos)
	{
		return $this->configSetAbbos(Dog_ForumAbbo::implodeAbbos($abbos));
	}
	
	public function getBoard($arg)
	{
		$results = array();
		foreach (self::$CACHE as $board)
		{
			$board instanceof Dog_Forum;
			if ($board->getID() == $arg)
			{
				return $board;
			}
		}
		
		
		foreach (self::$CACHE as $board)
		{
			if (   (stripos($board->getURL(), $arg) !== false)
				|| (stripos($arg, $board->getTLD()) !== false)
				|| (GWF_HTTP::getDomain($arg) === $board->getTLD()) )
			{
				return $board;
			}
		}
		return false;
	}
	
	
	public function onTimer()
	{
		foreach (self::$CACHE as $board)
		{
			if ($board->isEnabled())
			{
				$this->onBoardTimer($board);
			}
		} 
	}
	
	private function onBoardTimer(Dog_Forum $board)
	{
		if (false === ($entries = $board->fetchNewEntries(10)))
		{
		    $board->saveOption(Dog_Forum::DELETED, true);
			return Dog_Log::warn('Forum Board Activities corrupt!');
		}
		
		if (count($entries) > 0)
		{		
			foreach (Dog::getServers() as $server)
			{
				$this->onBoardServerTimer($entries, $board, $server);
			}
			
			$board->updateDatestamp(array_pop($entries));
		}
	}

	private function onBoardServerTimer(array $entries, Dog_Forum $board, Dog_Server $server)
	{
		foreach ($server->getChannels() as $channel)
		{
			if ($this->isEnabled($server, $channel))
			{
				$this->onBoardServerChannelTimer($entries, $board, $server, $channel);
			}
		}
	}

	private function onBoardServerChannelTimer(array $entries, Dog_Forum $board, Dog_Server $server, Dog_Channel $channel)
	{
		if ('' === ($boardstring = Dog_Conf_Mod_Chan::getConf($this->getName(), $channel->getID(), 'boards', '')))
		{
			return;
		}
		$boardstr = explode(';', $boardstring);
		foreach ($boardstr as $boardst)
		{
			$abbo = new Dog_ForumAbbo($boardst);
			foreach ($entries as $entry)
			{
				$entry instanceof Dog_ForumEntry;
				if ($abbo->matches($board, $entry))
				{
					$this->sendAbbo($board, $channel, $entry);
				}
			}
		}
	}
	
	private function sendAbbo(Dog_Forum $board, Dog_Channel $channel, Dog_ForumEntry $entry)
	{
		$channel->sendPRIVMSG($this->lang('msg_entry', array($board->getTitle(), $entry->getUserName(), $entry->getTitle(), $entry->getURL())));
	}
}
?>
