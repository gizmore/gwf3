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
	
	public function getNPCQuest(SR_Player $player)
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
	
	public function onNPCQuestTalk(SR_Player $player, $word)
	{
		if (false === ($q = $this->getNPCQuest($player))) {
			return false;
		}
		
		$key = $q->getTempKey();
		$has = $q === false ? false : $q->isInQuest($player);
		$t = $player->hasTemp($key);
		
		switch ($word)
		{
			case 'shadowrun':
				if ($has === true) {
					$q->checkQuest($this, $player);
				}
				elseif ($t === true) {
					$q->onNPCQuestTalk($this, $player, 'confirm');
				}
				else {
					$q->onNPCQuestTalk($this, $player, $word);
					$player->setTemp($key, 1);
				}
				return true;
				
			case 'yes':
				if ($t === true) {
					$q->accept($player);
					$q->onNPCQuestTalk($this, $player, $word);
					$player->unsetTemp($key);
					return true;
				}
				return false;
				
			case 'no':
				if ($t === true) {
					$q->onNPCQuestTalk($this, $player, $word);
					$player->unsetTemp(self::TEMP_WORD);
					return true;
				}
				return false;
				
			default:
				return false;
		}
	}
}
?>