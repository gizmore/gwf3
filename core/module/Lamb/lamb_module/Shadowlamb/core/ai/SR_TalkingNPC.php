<?php
require_once 'SR_NPC.php';

/**
 * Talking and quest extension.
 * @author gizmore
 */
abstract class SR_TalkingNPC extends SR_NPC
{
//	public function getName() { return __CLASS__; }
	public function isNPCFriendly(SR_Party $party) { return true; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	############
	### Lang ###
	############
	public function langNPCB($player, $key, $args=NULL)
	{
		return Shadowlang::langNPC($this, $player, $key, $args);
	}
	
	public function langNPC($key, $args=NULL)
	{
		return $this->langNPCB($this->chat_partner, $key, $args);
	}
	
	################
	### NPC Talk ###
	################
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if (true === $this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		
		echo __METHOD__;
		$key = 'word_'.$word;
		if ($key === ($text = $this->langNPCB($player, $key)))
		{
			return $this->reply($this->langNPCB($player, 'word_default'));
		}
		return $this->reply($text);
	}
	
	public function reply($message)
	{
		$b = chr(2);
		$player = $this->chat_partner;
		$p = $player->getParty();
		$message = sprintf('%s says: "%s"', $b.$this->getName().$b, $message);
		if ($p->isTalking())
		{
			$p->notice($message);
		}
		else
		{
			$player->message($message);
		}
		return true;
	}
	
	/**
	 * Multi lang version of NPC->reply.
	 * @param string $key
	 * @param arry $args
	 * @return boolean
	 */
	public function rply($key, $args=NULL)
	{
		$player = $this->chat_partner;
		$p = $player->getParty();
		if (true === $p->isTalking())
		{
			return $this->partyRply($key, $args);
		}
		else
		{
			$message = $player->lang('5085', array($this->getName(), Shadowlang::langNPC($this, $player, $key, $args)));
			return $player->message($message);
		}
	}
	
	public function partyRply($key, $args=NULL)
	{
		$player = $this->chat_partner;
		$p = $player->getParty();
		foreach ($p->getMembers() as $member)
		{
			$message = $member->lang('5085', array($this->getName(), Shadowlang::langNPC($this, $member, $key, $args)));
			$member->message($message);
		}
	}
	
	public function bye()
	{
		$player = $this->chat_partner;
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		if ($p->isTalking())
		{
			$p->popAction(true);
			$ep->popAction(false);
		}
		return true;
	}
	
	##############
	### Quests ###
	##############
	/**
	 * Get quests triggered with helper functions.
	 */
	public function getNPCQuests(SR_Player $player) { return array(); }
	
	protected function getNPCQuest(SR_Player $player)
	{
		foreach ($this->getNPCQuests($player) as $name)
		{
			$quest = SR_Quest::getQuest($player, $name);
			if  ( (!$quest->isDone($player)) && (!$quest->isFailed($player)) && (!$quest->isDeclined($player)) )
			{
				return $quest;
			}
		}
		return false;
	}
	
	public function onNPCBountyTalk(SR_Player $player, $word, array $args)
	{
		switch (count($args))
		{
			case 1:
				$this->reply("Yes. Try #ttj bounty <player{server}> to see the bounty for a player. Try #ttj bounty <player{server}> <nuyen> to raise the bounty for a player.");
				return true;
			
			case 2:
				if (false === ($target = Shadowrun4::loadPlayerByName($args[1])))
				{
					$this->reply("This player is unknown. Try #ttj <nickname{serverid}>.");
				}
				else
				{
					$this->reply(SR_Bounty::displayBountyPlayer($target));
				}
				return true;
				
			case 3:
				
				if (false === ($target = Shadowrun4::loadPlayerByName($args[1])))
				{
					$this->reply("This player is unknown. Try #ttj <nickname{serverid}>.");
					return true;
				}
				
				$nuyen = (int)$args[2];
				$min_nuyen = SR_Bounty::getMinNuyen($target);
				if ($nuyen < $min_nuyen)
				{
					$this->reply(sprintf('The minimum bounty for %s is %s.', $target->getName(), Shadowfunc::displayNuyen($min_nuyen)));
					return true;
				}
				
				if (false === ($player->pay($nuyen)))
				{
					$this->reply(sprintf("You don't seem to have %s.", Shadowfunc::displayNuyen($nuyen)));
					return false;
				}
				
				if (false === SR_Bounty::insertBounty($player, $target, $nuyen))
				{
					$this->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}
				
				$bounty = Shadowfunc::displayNuyen($nuyen);
				$total = Shadowfunc::displayNuyen($target->getBase('bounty'));
				
				$target->message(sprintf("\x02%s put a bounty on you: +%s = %s!\x02", $player->getName(), $bounty, $total));
				$this->reply(sprintf('You put a bounty of %s on %s. This is valid for %s. Total bounty for this chummer is %s now.', $bounty, $target->getName(), GWF_TimeConvert::humanDuration(SR_Bounty::TIMEOUT), $total));
				
				return true;
				
			default:
				return false;
		}
	}
	
	
	public function onNPCQuestTalk(SR_Player $player, $word, array $args=NULL)
	{
		if (false === ($q = $this->getNPCQuest($player)))
		{
// 			Lamb_Log::logDebug('No more auto-quests.');
			return false;
		}
		
		$q instanceof SR_Quest;
		
		$key = $q->getTempKey();
		$has = $q->isInQuest($player);
		$t = $player->hasTemp($key);
		
		switch ($word)
		{
			case $q->getTrigger():
				if ($has === true)
				{
					$q->checkQuest($this, $player);
				}
				elseif ($t === true)
				{
					$q->onNPCQuestTalk($this, $player, 'confirm', $args);
				}
				else
				{
					if ($q->onNPCQuestTalk($this, $player, $word, $args))
					{
						$player->setTemp($key, 1);
					}
				}
				return true;
				
			case 'yes':
				if ($t === true)
				{
					$q->accept($player);
					$player->unsetTemp($key);
					$q->onNPCQuestTalk($this, $player, $word, $args);
					return true;
				}
				return false;
				
			case 'no':
				if ($t === true)
				{
					$q->onNPCQuestTalk($this, $player, $word, $args);
					$player->unsetTemp($key);
					return true;
				}
				return false;
				
			default:
				if (true === in_array($word, $q->getTriggers(), true))
				{
					return $q->onNPCQuestTalk($this, $player, $word, $args);
				}
				return false;
		}
	}
	
	public function onByeChat(SR_Player $player)
	{
		$p = $this->getParty();
		$ep = $player->getParty();
		$p->popAction(true);
		$ep->popAction(true);
		$p->setContactEta(rand(10, 20));
		$ep->setContactEta(rand(10, 20));
		return true;
	}
}
?>