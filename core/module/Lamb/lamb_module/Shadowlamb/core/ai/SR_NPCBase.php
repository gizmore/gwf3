<?php
/**
 * Base NPC creation.
 * @author gizmore
 * @see SR_NPC
 */
abstract class SR_NPCBase extends SR_Player
{
	public static $NPC_COUNTER = 0;
	protected $chat_partner = NULL;
	private $npc_classname;
	
	#############
	### Arena ###
	#############
	private $arena_key = NULL;
	private $arena_ny = 0;
	public function setArenaKey($key, $bit)
	{
		$this->arena_key = "{$bit}:{$key}";
	}
	public function setArenaNuyen($nuyen)
	{
		$this->arena_ny = $nuyen;
	}
	public function setChatPartner(SR_Player $player)
	{
		$this->chat_partner = $player;
	}
	#################
	### SR_Player ###
	#################
	public function getName() { return sprintf('%s[%d]', $this->getVar('sr4pl_name'), $this->getID()); }
	public function displayName() { return sprintf("\x02%s\x02", $this->getName()) ; }
	public function getShortName() { return $this->getName(); }
	public function help($message) { $this->message($message); }
	public function isCreated() { return true; }
	public function getLootNuyen() { return $this->getBase('nuyen'); }
	public function getUser() { return NULL; }
	public function getLangISO() { return 'en'; }
	
	/**
	 * NPC messages are queued to a player on remote commands.
	 * @see SR_Player::message()
	 */
	public function message($message)
	{
		Lamb_Log::logDebug($message);
		if (false !== ($user = $this->getRemotePlayer()))
		{
			$user->message($message);
		}
		return true;
	}
	
	###########
	### NPC ###
	###########
	public function getNPCLevel() { return 1; }
	public function getLootXP() { return Shadowfunc::diceFloat(1, 2+$this->getBase('level')/5, 1) + $this->getNPCLootXP(); }
	public function getNPCLootXP() { return 0; }
	public function getNPCCityClass() { return Shadowrun4::getCity(Common::substrUntil($this->getNPCClassName(), '_')); }
	public function setNPCClassName($classname) { $this->npc_classname = $classname; }
	public function getNPCClassName() { return $this->npc_classname; }
	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function isNPCFriendly(SR_Party $party) { return false; }
	public function isNPCDropping(SR_Party $party) { return true; }
	public function getNPCEquipment() { return array(); }
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() { return array(); }
	public function getNPCModifiersB() { return array(); }
	public function getNPCSpells() { return array(); }
	public function getNPCCyberware() { return array(); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
	}
	
	public function onNPCTalkA(SR_Player $player, $word, array $args)
	{
		if (empty($word)) {
//		if ($word === '') {
			$word = 'hello';
		}
		elseif (is_numeric($word)) {
			if (false === ($word = $player->getKnowledgeByID('words', $word))) {
				$word = 'hello';
			}
		}
		
		$this->chat_partner = $player;
		return $this->onNPCTalk($player, strtolower($word), $args);

		# teach guessed word
//		foreach (SR_Player::$WORDS as $word2)
//		{
//			if (strcasecmp($word, $word2))
//			{
//				$player->giveKnowledge('words', $word2);
//			}
//		}
	}

	/**
	 * Probably for patching npcs.
	 * @param array $data
	 * @return array
	 */
	private function applyNPCStartData(array $data)
	{
		$mods = $this->getNPCModifiers();
		
		### Init NPC from race base values
		if (isset($mods['race']))
		{
			$race = $mods['race'];
		}
		else if (isset($data['race']))
		{
			$race = $data['race'];
		}
		else
		{
			$race = 'human';
		}
		# base essence
		$data['sr4pl_essence'] = 6.0;
		# base race
		$race_base = self::$RACE_BASE[$race];
		foreach ($race_base as $k => $v)
		{
			$data['sr4pl_'.$k] = $v;
		}
		
		# base race bonus
// 		$race_bonus = self::$RACE[$race];
// 		foreach ($race_bonus as $k => $v)
// 		{
// 			# Combat stats don't belong in the db.
// 			if (SR_Player::isCombatStat($k))
// 			{
// 				continue;
// 			}
			
// 			$data['sr4pl_'.$k] += $v;
// 		}

		### Now override with specified values
		foreach ($mods as $k => $v)
		{
			$data['sr4pl_'.$k] = $v;
		}
		
		### Apply difficulty patch
		$malus = rand(2, 4);
		$data['sr4pl_hp'] -= $malus;
		$data['sr4pl_base_hp'] -= $malus;
		
		### Apply needed missing vars
		$data['sr4pl_level'] = $this->getNPCLevel();
		$data['sr4pl_quests_done'] = 0;
		
		return $data;
	}
	
	/**
	 * Create a new enemy party with arbitary amount of enemies.
	 * @see SR_NPCBase::spawn
	 * @return SR_Party
	 */
	public static function createEnemyParty()
	{
		$names = array();
		foreach (func_get_args() as $arg)
		{
			if (is_array($arg))
			{
				$names = array_merge($names, $arg);
			}
			else
			{
				$names[] = $arg;
			}
		}
		
		# Validate
		if (count($names) === 0)
		{
			Lamb_Log::logError('WARNING: Empty party is empty!');
		}
		
		$npcs = array();
		foreach ($names as $classname)
		{
			if (false === ($npc = Shadowrun4::getNPC($classname)))
			{
				Lamb_Log::logError('Unknown NPC classname in createEnemyParty: '.$classname);
				return false;
			}
			$npcs[] = $npc;
		}
		
		$party = SR_Party::createParty();
		
		foreach ($npcs as $npc)
		{
			$npc instanceof SR_NPC;
			if (false === $npc->spawn($party))
			{
				Lamb_Log::logError('Failed to spawn NPC: '.$npc->getNPCClassName());
			}
		}
			
		$party->updateMembers();
		$party->recomputeEnums();
		
		return $party;
	}
	
	/**
	 * Create a single NPC, optionally make it join a party. Else create blank party.
	 * @param string $classname
	 * @param NULL|SR_Party $party
	 * @return SR_NPC
	 */
	public static function createEnemyNPC($classname, $party=NULL)
	{
		if (false === ($npc = Shadowrun4::getNPC($classname)))
		{
			return Lamb_Log::logError('Unknown NPC classname in createEnemyNPC: '.$classname);
		}
		
		if ($party === NULL)
		{
			if (false === ($party = SR_Party::createParty()))
			{
				return Lamb_Log::logError('Cannot create party in createEnemyNPC.');
			}
		}
		elseif (!($party instanceof SR_Party))
		{
			return Lamb_Log::logError('WRONG ARG IN in createEnemyNPC: '.$party);
		}
		
		if (false === $npc->spawn($party))
		{
			return Lamb_Log::logError('Failed to spawn NPC: '.$npc->getNPCClassName());
		}
		
		if (false === $party->updateMembers())
		{
			return Lamb_Log::logError('DB ERROR IN in createEnemyNPC.');
		}
		
		$party->recomputeEnums();

		return $npc;
	}
	
	/**
	 * Create an NPC and set a valid partyid.
	 * @param string $classname
	 * @return SR_NPC
	 */
	private function createNPC($classname, SR_Party $party, SR_Party $attackers=NULL)
	{
		$data = $this->applyNPCStartData(self::getPlayerData(NULL));
		$data['sr4pl_classname'] = $classname;
		$npc = new $classname($data);
		$npc->setNPCClassName($classname);
		$npc instanceof SR_NPC;
		$npc->setOption(self::CREATED, true);
		$npc->setVar('sr4pl_name', $npc->getNPCPlayerName());
		if (false === ($npc->insert()))
		{
			return false;
		}
		$party->addUser($npc, false);
		$npc->saveVar('sr4pl_partyid', $party->getID());
		return self::reloadPlayer($npc);
	}
	
	/**
	 * Spawn a copy of this NPC.
	 * @return SR_NPC
	 */
	public function spawn(SR_Party $party, SR_Party $attackers=NULL)
	{
		if (false === ($npc = self::createNPC($this->getNPCClassName(), $party, $attackers)))
		{
			Lamb_Log::logError(sprintf('SR_NPC::spawn() failed for NPC class: %s.', $this->getNPCClassName()));
			return false;
		}
		
		foreach ($this->getNPCEquipment() as $field => $itemname)
		{
			if (is_array($itemname))
			{
				$itemname = Shadowfunc::randomListItem($itemname);
			}
			
			if (!in_array($field, SR_Player::$EQUIPMENT, true))
			{
				Lamb_Log::logError(sprintf('NPC %s has invalid equipment type: %s.', $this->getNPCPlayerName(), $field));
				$npc->deletePlayer();
				return false;
			}
			
			if (false === ($item = SR_Item::createByName($itemname)))
			{
				Lamb_Log::logError(sprintf('NPC %s has invalid %s: %s.', $this->getNPCPlayerName(), $field, $itemname));
				$npc->deletePlayer();
				return false;
			}
			
			$item->saveVar('sr4it_uid', $npc->getID());
			$npc->updateEquipment($field, $item);
		}
		
		foreach ($this->getNPCCyberware() as $itemname)
		{
			$npc->addCyberware(SR_Item::createByName($itemname));
		}

		$inv = array();
		foreach ($this->getNPCInventory() as $itemname)
		{
			if (false === ($item = SR_Item::createByName($itemname)))
			{
				Lamb_Log::logError(sprintf('NPC %s has invalid inventory item: %s.', $this->getNPCPlayerName(), $itemname));
				$npc->deletePlayer();
				return false;
			}
			$inv[] = $item;
		}
		
		$npc->giveItems($inv);
		
		$npc->saveSpellData($this->getNPCSpells());
		
		$npc->modify();
		
		$npc->healHP(10000);
		$npc->healMP(10000);
		
		return $npc;
	}
	
	##############
	### Killed ###
	##############
	public function gotKilledByNPC(SR_Player $player)
	{
		return $this->gotKilledByHuman($player);
	}

	public function gotKilledByHuman(SR_Player $player)
	{
		if ($this->isNPCDropping($player->getParty()))
		{
			$player = $player->getParty()->getKiller($player);
			
			$items = array_merge(
				Shadowfunc::randLoot($player, (int)$this->getBase('level'), $this->getNPCHighChanceDrops()), 
				$this->generateNPCLoot($player)
			);
			$player->giveItems($items, 'looting '.$this->getName());
		}
	}
	
	private function getNPCHighChanceDrops()
	{
		$back = array();

		foreach ($this->getNPCInventory() as $itemname)
		{
			if (false === in_array($itemname, $back, true))
			{
				$back[] = $itemname;
			}
		}
		
		foreach ($this->getAllEquipment(false) as $item)
		{
			$item instanceof SR_Item;
			$itemname = $item->getName();
			if (false === in_array($itemname, $back, true))
			{
				$back[] = $itemname;
			}
		}
		
		return $back;
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
		$this->deletePlayer();
	}
	
	public function getNPCLoot(SR_Player $player)
	{
		if ($this->arena_ny > 0)
		{
			$ny = $this->arena_ny;
			$player->msg('5125', array(Shadowfunc::displayNuyen($ny)));
// 			$player->message(sprintf('You get a reward of %s for killing the enemy.', Shadowfunc::displayNuyen($ny)));
			$player->giveNuyen($ny);
		}
		
		if ($this->arena_key === NULL)
		{
			return array();
		}
		list($bit, $key) = explode(':', $this->arena_key);
		$bits = (int)SR_PlayerVar::getVal($player, $key, 0);
		$bits |= $bit;
		SR_PlayerVar::setVal($player, $key, $bits);
		return array();
	}
}
?>
