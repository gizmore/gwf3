<?php
abstract class SR_NPC extends SR_Player
{
	public static $NPC_COUNTER = 0;
	
	#################
	### SR_Player ###
	#################
	public function getName() { return sprintf('%s[%d]', $this->getVar('sr4pl_name'), $this->getID()); }
	public function getShortName() { return $this->getName(); }
	public function help($message) { $this->message($message); }
	public function message($message) { Lamb_Log::log($message); }
	public function isCreated() { return true; }
	public function getLootNuyen() { return $this->getBase('nuyen'); }
	
	protected $chat_partner = NULL;
	
	###########
	### NPC ###
	###########
	private $npc_classname;
	public function getNPCLevel() { return 9999; }
	public function setNPCClassName($classname) { $this->npc_classname = $classname; }
	public function getNPCClassName() { return $this->npc_classname; }
	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function isNPCFriendly(SR_Party $party) { return false; }
	public function getNPCEquipment() { return array(); }
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() { return array(); }
	public function getNPCModifiersB() { return array(); }
	public function getNPCSpells() { return array(); }
	public function getNPCLoot(SR_Player $player) { return array(); }
	public function onNPCTalk(SR_Player $player, $word) { print(sprintf('IMPLEMENT: %s(%s)', __CLASS__, __METHOD__, $word)); }
	public function onNPCTalkA(SR_Player $player, $word)
	{
		if ($word === '') {
			$word = 'hello';
		}
		elseif (is_numeric($word)) {
			if (false === ($word = $player->getKnowledgeByID('words', $word))) {
				$word = 'hello';
			}
		}
		
		$this->chat_partner = $player;
		$this->onNPCTalk($player, strtolower($word));
	}
	
	private function applyNPCStartData(array $data)
	{
		$mods = $this->getNPCModifiers();
		
		if (isset($mods['race'])) {
			$race = $mods['race'];
		}
		else if (isset($data['race'])) {
			$race = $data['race'];
		}
		else {
			$race = 'human';
		}
		$race = self::$RACE_BASE[$race];
		foreach ($race as $k => $v)
		{
			$data['sr4pl_'.$k] = $v;
		}
		
		foreach ($mods as $k => $v)
		{
			$data['sr4pl_'.$k] = $v;
		}
		
		$malus = rand(2, 4);
		$data['sr4pl_hp'] -= $malus;
		$data['sr4pl_base_hp'] -= $malus;
		
		$data['sr4pl_level'] = $this->getNPCLevel();
		return $data;
	}
	
	/**
	 * Create a new enemy party with arbitary amount of enemies.
	 * @return SR_Party
	 */
	public static function createEnemyParty()
	{
		$names = array();
		foreach (func_get_args() as $arg)
		{
			if (is_array($arg)) {
				$names = array_merge($names, $arg);
			}
			else {
				$names[] = $arg;
			}
		}
		
		# Validate
		if (count($names) === 0) {
			Lamb_Log::log('Can not create empty party!');
			return false;
		}
		
		$npcs = array();
		foreach ($names as $classname)
		{
			if (false === ($npc = Shadowrun4::getNPC($classname)))
			{
				Lamb_Log::log('Unknown NPC classname in createEnemyParty: '.$classname);
				return false;
			}
			$npcs[] = $npc;
		}
		
		$party = SR_Party::createParty();
		foreach ($npcs as $npc)
		{
			$npc instanceof SR_NPC;
			if (false === $npc->spawn($party)) {
				Lamb_Log::log('Failed to spawn NPC: '.$npc->getNPCClassName());
			}
		}
		
		$party->updateMembers();
		return $party;
	}
	
	/**
	 * Create an NPC and set a valid partyid.
	 * @param string $classname
	 * @return SR_NPC
	 */
	private function createNPC($classname, SR_Party $party)
	{
		$data = $this->applyNPCStartData(self::getPlayerData(NULL));
		$data['sr4pl_classname'] = $classname;
		$npc = new $classname($data);
		$npc->setVar('sr4pl_name', $npc->getNPCPlayerName());
		$npc instanceof SR_NPC;
		if (false === ($npc->insert())) {
			return false;
		}
		$party->addUser($npc, false);
		$npc->saveVar('sr4pl_partyid', $party->getID());
		return self::reloadPlayer($npc);
	}
	
//	public function diceNPCMeet(SR_Party $party)
//	{
//		
//		$this->getN
//		return true;
//	}
	
	/**
	 * Spawn a copy of this NPC.
	 * @return SR_NPC
	 */
	public function spawn(SR_Party $party)
	{
		if (false === ($npc = self::createNPC($this->getNPCClassName(), $party))) {
			Lamb_Log::log(sprintf('SR_NPC::spawn() failed for NPC class: %s.', $this->getNPCClassName()));
			return false;
		}
		
		foreach ($this->getNPCEquipment() as $field => $itemname)
		{
			if (is_array($itemname)) {
				shuffle($itemname);
				$itemname = array_pop($itemname);
			}
			
			if (!in_array($field, SR_Player::$EQUIPMENT, true))
			{
				Lamb_Log::log(sprintf('NPC %s has invalid equipment type: %s.', $this->getNPCPlayerName(), $field));
				$npc->deletePlayer();
				return false;
			}
			
			if (false === ($item = SR_Item::createByName($itemname))) {
				Lamb_Log::log(sprintf('NPC %s has invalid %s: %s.', $this->getNPCPlayerName(), $field, $itemname));
				$npc->deletePlayer();
				return false;
			}

			$item->saveVar('sr4it_uid', $npc->getID());
			$npc->updateEquipment($field, $item);
		}

		$inv = array();
		foreach ($this->getNPCInventory() as $itemname)
		{
			if (false === ($item = SR_Item::createByName($itemname))) {
				Lamb_Log::log(sprintf('NPC %s has invalid inventory item: %s.', $this->getNPCPlayerName(), $itemname));
				$npc->deletePlayer();
				return false;
			}
			$inv[] = $item;
		}
		
		$npc->giveItems($inv);
		
		$npc->saveSpellData($this->getNPCSpells());
		
		$npc->healHP(10000);
		$npc->healMP(10000);
		
		$npc->modify();
		
		return $npc;
	}

	public function gotKilledByNPC(SR_Player $player)
	{
		Lamb_Log::log(__CLASS__.'::'.__METHOD__);
	}

	public function gotKilledByHuman(SR_Player $player)
	{
		$items = array_merge(
			Shadowfunc::randLoot($player, (int)$this->getBase('level')), 
			$this->generateNPCLoot($player)
		);
		$player->giveItems($items);
	}

	private function generateNPCLoot(SR_Player $player)
	{
		$back = array();
		foreach ($this->getNPCLoot($player) as $itemname)
		{
			$back[] = SR_Item::createByName($itemname);
		}
		return $back;
	}
	
	public function respawn()
	{
//		Lamb_Log::log(__METHOD__);
		$this->deletePlayer();
	}
	
	##########
	### AI ###
	##########
	public function combatTimer()
	{
		
		
		
		// Exec
		parent::combatTimer();
	}
}

###################
### Talking NPC ###
###################
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
		$this->chat_partner->message(sprintf('%s says: "%s"', $this->getName(), $message));
	}
}
abstract class SR_HireNPC extends SR_TalkingNPC
{
	const HIRE_END = 'hire';
	
	public function onHire(SR_Player $player, $price, $time)
	{
		$p = $player->getParty();
		if ($p->hasHireling()) {
			return "You already have a runner. I work alone.";
		}
		
		if ($price > 0)
		{
			if ($player->getNuyen() < $price) {
				return "I want {$price} nuyen to join join your party.";
			}
		}
		
		$this->onHireB($player, $price, $time);
		
		return "Ok chummers, let's go!";
	}
	
	public function onHireB(SR_Player $player, $price, $time)
	{
		$p = $player->getParty();
		$player->giveNuyen(-$price);
		$npc = $this->spawn($p);
		$npc->onHireC($player, $time);
	}
	
	public function onHireC(SR_Player $player, $time)
	{
		$player->getParty()->addUser($this, true);
		$this->onSetHireTime($time);
	}
	
	public function onSetHireTime($time)
	{
		$this->setConst(self::HIRE_END, Shadowrun4::getTime() + $time);
	}
	
	public function onAddHireTime($seconds)
	{
		$this->setConst(self::HIRE_END, $this->getConst(self::HIRE_END) + $seconds);
	}
	
	public function hasToLeave()
	{
		if (!$this->hasConst(self::HIRE_END)) {
			return false;
		}
		return $this->getConst(self::HIRE_END) < Shadowrun4::getTime();
	}
}
?>
