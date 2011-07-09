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
	
	################
	### NPC Talk ###
	################
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
			if (!$quest->isDone($player))
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
	
	
	public function onNPCQuestTalk(SR_Player $player, $word)
	{
		if (false === ($q = $this->getNPCQuest($player)))
		{
			return false;
		}
		
		$key = $q->getTempKey();
		$has = $q->isInQuest($player);
		$t = $player->hasTemp($key);
		
		switch ($word)
		{
			case 'shadowrun':
				if ($has === true)
				{
					$q->checkQuest($this, $player);
				}
				elseif ($t === true)
				{
					$q->onNPCQuestTalk($this, $player, 'confirm');
				}
				else
				{
					$q->onNPCQuestTalk($this, $player, $word);
					$player->setTemp($key, 1);
				}
				return true;
				
			case 'yes':
				if ($t === true)
				{
					$q->accept($player);
					$player->unsetTemp($key);
					$q->onNPCQuestTalk($this, $player, $word);
					return true;
				}
				return false;
				
			case 'no':
				if ($t === true)
				{
					$q->onNPCQuestTalk($this, $player, $word);
					$player->unsetTemp($key);
					return true;
				}
				return false;
				
			default:
				return false;
		}
	}
}
?>