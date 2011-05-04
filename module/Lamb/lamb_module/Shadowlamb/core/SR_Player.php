<?php
class SR_Player extends GDO
{
	const BASE_HP = 4;
	const BASE_MP = 0;
	const HP_PER_BODY = 2;
	const MP_PER_MAGIC = 5;
	const XP_PER_KARMA = 8;
	const XP_PER_KARMA_RAISE = 0.5;
	const XP_PER_LEVEL = 25;
	const XP_PER_LEVEL_RAISE = 5;
	const WEIGHT_BASE = 6000;
	const WEIGHT_PER_STRENGTH = 1800;
	const FIGHT_INIT_BUSY = 25;
	const MAX_RANGE = 20.0;
	
	# Human Starter
	const START_HP = 4;
	const START_NUYEN = 75;
	
	# Options
	const CREATED = 0x01;
	const HELP = 0x02;
	const NOTICE = 0x00;
	const PRIVMSG = 0x04;
	
	# WWW hack
	const WWW_OUT = 0x10;
	const INV_DIRTY = 0x20;
	const CMD_DIRTY = 0x40;
	const STATS_DIRTY = 0x80;
	const EQ_DIRTY = 0x100;
	const PARTY_DIRTY = 0x200;
	const LOCATION_DIRTY = 0x400;
	const CYBER_DIRTY = 0x800;
	const WORDS_DIRTY = 0x1000;
	const RESPONSE_ITEMS = 0x2000;
	const RESPONSE_PLAYERS = 0x4000;
	const DIRTY_FLAGS = 0x7fe0;
	
	public static $STATS = array('max_weight','attack','defense','min_dmg','max_dmg','marm','farm','max_hp','max_mp',);
	public static $ATTRIBUTE = array('bo'=>'body','ma'=>'magic','st'=>'strength','qu'=>'quickness','wi'=>'wisdom','in'=>'intelligence','ch'=>'charisma','lu'=>'luck','re'=>'reputation','es'=>'essence');
	public static $SKILL = array('mel'=>'melee','nin'=>'ninja','fir'=>'firearms','bow'=>'bows','pis'=>'pistols','sho'=>'shotguns','smg'=>'smgs','hmg'=>'hmgs','com'=>'computers','ele'=>'electronics','bio'=>'biotech','neg'=>'negotiation','sha'=>'sharpshooter','sea'=>'searching','loc'=>'lockpicking','thi'=>'thief');
	public static $KNOWLEDGE = array('icu'=>'indian_culture','ila'=>'indian_language');
	public static $EQUIPMENT = array('am'=>'amulet','ar'=>'armor','bo'=>'boots','ea'=>'earring','he'=>'helmet','le'=>'legs','ri'=>'ring','sh'=>'shield','we'=>'weapon');
	public static $RACE = array(
		'fairy' =>    array('body'=>0,'magic'=> 5,'strength'=>-2,'quickness'=>2,'wisdom'=>4,'intelligence'=>4,'charisma'=> 4,'luck'=>2),
		'elve' =>     array('body'=>1,'magic'=> 4,'strength'=>-1,'quickness'=>3,'wisdom'=>2,'intelligence'=>3,'charisma'=> 2),
		'halfelve' => array('body'=>1,'magic'=> 3,'strength'=> 0,'quickness'=>3,'wisdom'=>2,'intelligence'=>2,'charisma'=> 2),
		'darkelve' => array('body'=>1,'magic'=> 2,'strength'=> 0,'quickness'=>3,'wisdom'=>2,'intelligence'=>2,'charisma'=> 2),
		'woodelve' => array('body'=>1,'magic'=> 1,'strength'=> 0,'quickness'=>3,'wisdom'=>1,'intelligence'=>2,'charisma'=> 2),
		'human' =>    array('body'=>2,'magic'=> 0,'strength'=> 0,'quickness'=>3,'wisdom'=>1,'intelligence'=>2,'charisma'=> 1),
		'dwarf' =>    array('body'=>2,'magic'=> 0,'strength'=> 0,'quickness'=>2,'wisdom'=>1,'intelligence'=>2,'charisma'=> 1),
		'halfork' =>  array('body'=>3,'magic'=>-1,'strength'=> 1,'quickness'=>2,'wisdom'=>1,'intelligence'=>2,'charisma'=> 1),
		'halftroll'=> array('body'=>3,'magic'=>-2,'strength'=> 2,'quickness'=>2,'wisdom'=>0,'intelligence'=>1,'charisma'=> 0),
		'ork' =>      array('body'=>4,'magic'=>-3,'strength'=> 3,'quickness'=>1,'wisdom'=>1,'intelligence'=>1,'charisma'=> 0),
		'troll' =>    array('body'=>4,'magic'=>-4,'strength'=> 4,'quickness'=>0,'wisdom'=>0,'intelligence'=>0,'charisma'=> 0,'essence'=>-0.2),
		'gremlin' =>  array('body'=>1,'magic'=>-5,'strength'=> 2,'quickness'=>0,'wisdom'=>0,'intelligence'=>0,'charisma'=>-1,'reputation'=>3,'essence'=>-2.0),
	);
	public static $RACE_BASE = array(
		'fairy' =>    array('base_hp'=>2, 'base_mp'=>6, 'body'=>0,'magic'=> 1,'strength'=>0,'quickness'=>2,'wisdom'=>1,'intelligence'=>3,'charisma'=> 2,'luck'=>0),
		'elve' =>     array('base_hp'=>4, 'base_mp'=>4, 'body'=>1,'magic'=> 1,'strength'=>0,'quickness'=>3,'wisdom'=>0,'intelligence'=>2,'charisma'=> 1,'luck'=>0),
		'halfelve' => array('base_hp'=>5, 'base_mp'=>2, 'body'=>1,'magic'=>-1,'strength'=>1,'quickness'=>2,'wisdom'=>0,'intelligence'=>1,'charisma'=> 1,'luck'=>0),
		'darkelve' => array('base_hp'=>5, 'base_mp'=>1, 'body'=>1,'magic'=>-1,'strength'=>2,'quickness'=>2,'wisdom'=>0,'intelligence'=>1,'charisma'=> 1,'luck'=>0),
		'woodelve' => array('base_hp'=>5, 'base_mp'=>2, 'body'=>1,'magic'=>-1,'strength'=>1,'quickness'=>2,'wisdom'=>0,'intelligence'=>0,'charisma'=> 1,'luck'=>0),
		'human' =>    array('base_hp'=>6, 'base_mp'=>0, 'body'=>2,'magic'=>-1,'strength'=>1,'quickness'=>1,'wisdom'=>0,'intelligence'=>0,'charisma'=> 0,'luck'=>0),
		'dwarf' =>    array('base_hp'=>6, 'base_mp'=>0, 'body'=>2,'magic'=>-1,'strength'=>1,'quickness'=>1,'wisdom'=>0,'intelligence'=>0,'charisma'=> 0,'luck'=>0),
		'halfork' =>  array('base_hp'=>7, 'base_mp'=>-1,'body'=>2,'magic'=>-1,'strength'=>2,'quickness'=>1,'wisdom'=>0,'intelligence'=>0,'charisma'=> 0,'luck'=>0),
		'halftroll'=> array('base_hp'=>8, 'base_mp'=>-2,'body'=>3,'magic'=>-1,'strength'=>2,'quickness'=>0,'wisdom'=>0,'intelligence'=>0,'charisma'=> 0,'luck'=>0),
		'ork' =>      array('base_hp'=>9,'base_mp'=>-3,'body'=>3,'magic'=>-2,'strength'=>3,'quickness'=>0,'wisdom'=>0,'intelligence'=>0,'charisma'=> 0,'luck'=>0),
		'troll' =>    array('base_hp'=>10,'base_mp'=>-4,'body'=>3,'magic'=>-2,'strength'=>3,'quickness'=>0,'wisdom'=>0,'intelligence'=>0,'charisma'=> 0,'luck'=>0),
		'gremlin' =>  array('base_hp'=>11,'base_mp'=>-6,'body'=>1,'magic'=>-3,'strength'=>0,'quickness'=>2,'wisdom'=>0,'intelligence'=>0,'charisma'=> 0,'luck'=>0),
	);
	
	public static $GENDER = array(
		'male' => array('strength'=>1,'wisdom'=>1),
		'female' => array('charisma'=>2,'intelligence'=>1),
	);
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_player'; }
	public function getOptionsName() { return 'sr4pl_options'; }
	public function getColumnDefines()
	{
		$back = array(
			# ID
			'sr4pl_id' => array(GDO::AUTO_INCREMENT),
			'sr4pl_uid' => array(GDO::OBJECT|GDO::INDEX, GDO::NULL, array('Lamb_User', 'sr4pl_uid', 'lusr_id')),
			'sr4pl_partyid' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4pl_classname' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 63),
			'sr4pl_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 63),
			'sr4pl_title' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 63),
			'sr4pl_race' => array(GDO::ENUM, 'human', self::getRaces()),
			'sr4pl_gender' => array(GDO::ENUM, 'male', self::getGenders()),
			'sr4pl_options' => array(GDO::UINT, self::HELP),
			# Stats
			'sr4pl_hp' => array(GDO::DECIMAL, 0.0, array(7,2)),
			'sr4pl_base_hp' => array(GDO::INT, 1),
			'sr4pl_mp' => array(GDO::DECIMAL, 0.0, array(7,2)),
			'sr4pl_base_mp' => array(GDO::INT, 0),
			'sr4pl_distance' => array(GDO::DECIMAL, 0.0, array(2,1)),
			# Karma
			'sr4pl_xp' => array(GDO::DECIMAL, 0.0, array(7,2)),
			'sr4pl_xp_total' => array(GDO::DECIMAL, 0.0, array(7,2)),
			'sr4pl_karma' => array(GDO::UINT, 0),
			'sr4pl_karma_total' => array(GDO::UINT, 0),
			'sr4pl_bad_karma' => array(GDO::UINT, 0),
			'sr4pl_bad_karma_total' => array(GDO::UINT, 0),
			'sr4pl_xp_level' => array(GDO::DECIMAL, 0.0, array(7,2)),
			'sr4pl_level' => array(GDO::UINT, 0),
			# Nuyen
			'sr4pl_nuyen' => array(GDO::DECIMAL, 0.0, array(16,2)),
			'sr4pl_bank_nuyen' => array(GDO::DECIMAL, 0.0, array(16,2)),
			# Known
			'sr4pl_known_words' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4pl_known_spells' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4pl_known_places' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			# Items
			'sr4pl_bank' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4pl_inventory' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4pl_cyberware' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			# Effects
			'sr4pl_effects' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			# Vars
			'sr4pl_const_vars' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
		);
		foreach (self::$ATTRIBUTE as $key) { $back['sr4pl_'.$key] = array(GDO::INT, 0); }
		foreach (self::$EQUIPMENT as $key) { $back['sr4pl_'.$key] = array(GDO::UINT, 0); }
		foreach (self::$SKILL as $key) { $back['sr4pl_'.$key] = array(GDO::INT, -1); }
		foreach (self::$KNOWLEDGE as $key) { $back['sr4pl_'.$key] = array(GDO::INT, -1); }
		return $back;
	}
	
	# Oops
	public function getNPCModifiersB() { return array(); }
	
	###################
	### Convinience ###
	###################
	public function getID() { return $this->getInt('sr4pl_id'); }
	public function isNPC() { return $this->getVar('sr4pl_uid') === NULL; }
	public function isHuman() { return $this->getVar('sr4pl_uid') !== NULL; }
	public function isCreated() { return $this->isOptionEnabled(self::CREATED); }
	public function getRace() { return $this->getVar('sr4pl_race'); }
	public static function getRaces() { return array_keys(self::$RACE); }
	public function getGender() { return $this->getVar('sr4pl_gender'); }
	public function isMale() { return $this->getGender() === 'male'; }
	public function isFemale() { return $this->getGender() === 'female'; }
	public static function getGenders() { return array_keys(self::$GENDER); }
	public function getName() { $u = $this->getUser(); return sprintf('%s{%d}', $u->getName(), $u->getServerID()); }
	public function getShortName() { return $this->getUser()->getName(); }
	public function isFighting() { return $this->getParty()->isFighting(); }
	public function isDead() { return $this->getHP() <= 0; }
	public function hasSkill($skill) { return $this->getBase($skill) > -1; }
	public function isOverloaded() { return $this->get('weight') >= $this->get('max_weight'); }
	public function hasFullHP() { return $this->getHP() == $this->getMaxHP(); }
	public function hasFullMP() { return $this->getMP() == $this->getMaxMP(); }
	public function hasFullHPMP() { return $this->hasFullHP() && $this->hasFullMP(); }
	public function getHP() { return $this->getFloat('sr4pl_hp'); }
	public function getMP() { return $this->getFloat('sr4pl_mp'); }
	public function getMaxHP() { return $this->get('max_hp'); }
	public function getMaxMP() { return $this->get('max_mp'); }
	public function getNuyen() { return $this->getFloat('sr4pl_nuyen'); }
	public function getDistance() { return $this->getParty()->getDistance($this); }
	public function displayNuyen() { return Shadowfunc::displayPrice($this->getNuyen()); }
	public function isDrunk() { return $this->get('alc') >= 0.8+$this->get('body')/5+$this->get('strength')/10; }
	
	/**
	 * @return Lamb_User
	 */
	public function getUser() { return $this->getVar('sr4pl_uid'); }
	
	#################
	### Temp vars ###
	#################
	private $sr4_temp_vars = array();
	public function getTemp($key, $default=false) { return isset($this->sr4_temp_vars[$key]) ? $this->sr4_temp_vars[$key] : $default; }
	public function getTempVars() { return $this->sr4_temp_vars; }
	public function hasTemp($key) { return isset($this->sr4_temp_vars[$key]); }
	public function setTemp($key, $value) { $this->sr4_temp_vars[$key] = $value; }
	public function unsetTemp($key) { unset($this->sr4_temp_vars[$key]); }
	
	##################
	### Const vars ###
	##################
	private $sr4_const_vars = array();
	public function getConst($key) { return $this->sr4_const_vars[$key]; }
	public function getConstVars() { return $this->sr4_const_vars; }
	public function hasConst($key) { return isset($this->sr4_const_vars[$key]); }
	public function setConst($key, $value) { $this->sr4_const_vars[$key] = $value; $this->updateConstVars(); }
	public function unsetConst($key) { unset($this->sr4_const_vars[$key]); $this->updateConstVars(); }
	
	#################
	### Validator ###
	#################
	public static function isValidRace($race) { return array_key_exists($race, self::$RACE); }
	public static function isValidGender($gender) { return array_key_exists($gender, self::$GENDER); }
	
	##############
	### Static ###
	##############
	public static function getByID($player_id)
	{
		$db = gdo_db();
		$users = GWF_TABLE_PREFIX.'lamb_user';
		$players = GWF_TABLE_PREFIX.'sr4_player';
		$player_id = (int) $player_id;
		if (false === ($result = $db->queryFirst("SELECT p.*, u.* FROM $players p LEFT JOIN $users u ON lusr_id=sr4pl_uid WHERE sr4pl_id=$player_id", true))) {
			return false;
		}
		
		if (NULL !== ($classname = $result['sr4pl_classname'])) {
			$player = new $classname($result);
		} else {
			$player = new self($result);
			if ($result['sr4pl_uid'] !== NULL)
			{
				$player->setVar('sr4pl_uid', new Lamb_User($result));
			}
		}
		return self::reloadPlayer($player);
	}
	
	public static function getByUID($userid)
	{
		$userid = (int) $userid;
		return self::reloadPlayer(self::table(__CLASS__)->selectFirstObject('*', "sr4pl_uid=$userid"));
	}
	
	public static function getByLongName($username)
	{
		if (0 === ($sid = (int)Common::regex('/(\\d+)/', $username))) {
			return false;
		}
		$username = Shadowfunc::toShortname($username);
		$username = self::escape($username);
		if (false === ($player = self::table(__CLASS__)->selectFirstObject('*', "lusr_sid=$sid AND lusr_name='$username'"))) {
			return false;
		}
		return self::reloadPlayer($player);
	}
	
	public function initRaceGender()
	{
		foreach (SR_Item::mergeModifiers(self::$RACE_BASE[$this->getRace()], array('essence'=>6.0)) as $k => $v) {
			$mods['sr4pl_'.$k] = $v;
			unset($mods[$k]);
		}
		
		return $this->saveVars($mods);
	}
	
	public static function reloadPlayer($player)
	{
		if ($player === false){
			return false;
		} $player instanceof SR_Player;
		
		foreach (self::$EQUIPMENT as $e) {
			$player->reloadEquipment($e);
		}
		$player->sr4_inventory = $player->reloadItemArray('inventory');
		$player->sr4_cyberware = $player->reloadItemArray('cyberware');
		
		$player->reloadConstVars();
		
		$player->reloadEffects();
		
		$player->modify();
		
		return $player;
	}
	
	private function reloadConstVars()
	{
		if (NULL === ($s = $this->getVar('sr4pl_const_vars'))) {
			$this->sr4_const_vars = array();
		} else {
			$this->sr4_const_vars = unserialize($s);
		}
	}

	private function updateConstVars()
	{
		if (count($this->sr4_const_vars) === 0) {
			$s = NULL;
		} else {
			$s = serialize($this->sr4_const_vars);
		}
		return $this->saveVar('sr4pl_const_vars', $s);
	}
	
	private function reloadEquipment($key)
	{
		if ('0' === ($itemid = $this->getVar('sr4pl_'.$key))) {
			return;
		}
		if (false === ($item = SR_Item::getByID($itemid))) {
			return;
		}
		$this->sr4_equipment[$key] = $item; 
	}
	
	private function reloadItemArray($key)
	{
		$back = array();
		foreach (explode(',', $this->getVar('sr4pl_'.$key)) as $itemid)
		{
			$itemid = (int) $itemid;
			if (false !== ($item = SR_Item::getByID($itemid))) 
			{
				$back[$itemid] = $item;
			}
		}
		
		return $back;
	}
	
	private function reloadEffects()
	{
		$e = $this->getVar('sr4pl_effects');
		if (empty($e)) {
			$this->sr4_effects = array();
		}
		else {
			$this->sr4_effects = unserialize($e);
		}
	}
	
	public static function getPlayerData($userid=0)
	{
		$back = array(
			'sr4pl_id' => 0,
			'sr4pl_uid' => $userid,
			'sr4pl_partyid' => 0,
			'sr4pl_classname' => NULL,
			'sr4pl_name' => NULL,
			'sr4pl_title' => NULL,
			'sr4pl_race' => 'human',
			'sr4pl_gender' => 'male',
			'sr4pl_options' => self::HELP,
			'sr4pl_hp' => 0.0,
			'sr4pl_base_hp' => 0,
			'sr4pl_mp' => 0,
			'sr4pl_base_mp' => 0,
			'sr4pl_distance' => 0.0,
			'sr4pl_xp' => 0,
			'sr4pl_xp_total' => 0,
			'sr4pl_karma' => 0,
			'sr4pl_karma_total' => 0,
			'sr4pl_bad_karma' => 0,
			'sr4pl_bad_karma_total' => 0,
			'sr4pl_xp_level' => 0,
			'sr4pl_level' => 0,
			'sr4pl_nuyen' => 0,
			'sr4pl_bank_nuyen' => 0,
			'sr4pl_known_words' => ',',
			'sr4pl_known_spells' => ',',
			'sr4pl_known_places' => ',',
			'sr4pl_bank' => NULL,
			'sr4pl_inventory' => NULL,
			'sr4pl_cyberware' => NULL,
			'sr4pl_effects' => NULL,
			'sr4pl_const_vars' => NULL,
		);
		foreach (self::$ATTRIBUTE as $key) { $back['sr4pl_'.$key] = 0; }
		$back['sr4pl_magic'] = -1;
//		$back['sr4pl_essence'] = 6;
		foreach (self::$EQUIPMENT as $key) { $back['sr4pl_'.$key] = 0; }
		foreach (self::$SKILL as $key) { $back['sr4pl_'.$key] = -1; }
		foreach (self::$KNOWLEDGE as $key) { $back['sr4pl_'.$key] = -1; }
		return $back;
	}
	
	private static function applyStartData($data)
	{
		$data['sr4pl_nuyen'] = self::START_NUYEN;
		$data['sr4pl_base_hp'] = $data['sr4pl_hp'] = self::START_HP;
		return $data;
	}
	
	public static function createHuman(Lamb_User $user)
	{
		$human = self::createHumanB($user->getID(), $user->getName());
		$human->setVar('sr4pl_uid', $user);
		return $human;
	}
	public static function createHumanB($userid, $username)
	{
		$data = self::applyStartData(self::getPlayerData($userid));
		$data['sr4pl_name'] = $username;
		$human = new self($data);
		if (false === ($human->insert())) {
			return false;
		}
		$party = SR_Party::createParty();
		$party->pushAction('inside', 'Redmond_Hotel', 0);
		$party->addUser($human);
		$human->saveVar('sr4pl_partyid', $party->getID());
		$human = self::reloadPlayer($human);
		$human->healHP(10000);
		$human->healMP(10000);
		return $human;
	}
	
	public static function getPlayer(Lamb_User $user)
	{
		if (false === ($player = self::getByUID($user->getID()))) {
			$player = self::createHuman($user);
		}
		return $player;
	}
	
	#################
	### Messaging ###
	#################
	public function help($message)
	{
		if ($this->isOptionEnabled(self::HELP)) {
			$this->message($message);
		}
	}
	
	public function message($message)
	{
		if (NULL === ($user = $this->getUser())) {
			Lamb_Log::log('User does not exist: '.$message);
			return;
		}
		
		if ($this->isOptionEnabled(self::WWW_OUT)) {
			$this->onMessageWWW($message);
			return;
		}
		
		$username = $user->getName();
		if (false === ($server = $user->getServer())) {
			Lamb_Log::log(sprintf('User %s does not have a server: %s', $username, $message));
			return;
		}
		
		if ($server->getUser($username) === false) {
			$this->onMessageTell($message);
		} elseif ($this->isOptionEnabled(self::PRIVMSG)) {
			$server->sendPrivmsg($username, $message);
		} else {
			$server->sendNotice($username, $message);
		}
	}
	
	private function onMessageTell($message)
	{
		print('TELL: '.$message.PHP_EOL);
	}

	private function onMessageWWW($message)
	{
		Lamb_IRCFrom::insertMessage($this->getVar('sr4pl_id'), $message, $this->getVar('sr4pl_options'));
	}
	
	##############
	### INGAME ###
	##############
	private $sr4_data_modified = array();
	
	private $sr4_effects = array();
	private $sr4_inventory = array();
	private $sr4_cyberware = array();
	private $sr4_equipment = array();
	
	public function get($field) { return $this->sr4_data_modified[$field]; }
	public function getBase($field) { return $this->getVar('sr4pl_'.$field); }
	/**
	 * @return SR_Party
	 */
	public function getParty() { return Shadowrun4::getParty($this->getPartyID()); }
	public function getPartyID() { return $this->getVar('sr4pl_partyid'); }
	/**
	 * @return SR_Party
	 */
	public function getEnemyParty() { return $this->getParty()->getEnemyParty(); }
	public function isGM() { return Shadowrun4::isGM($this); }
	public function isLeader() { return $this->getParty()->isLeader($this); }
	public function deletePlayer()
	{
		SR_Item::deleteAllItems($this);
		$this->getParty()->kickUser($this, true);
		Shadowrun4::removePlayer($this);
		$this->delete();
	}
	
	public function respawn()
	{
		$party = $this->getParty();
		$city = $party->getCityClass();
		$party->kickUser($this, true);
		$new_party = SR_Party::createParty();
		$new_party->addUser($this, true);
		$location = $city->getRespawnLocation();
		$new_party->pushAction(SR_Party::ACTION_INSIDE, $location);
		$this->updateField('partyid', $new_party->getID());
		$this->message(sprintf('You respawn at %s.', $location));
	}
	
	##############
	### Modify ###
	##############
	public function modify()
	{
		$this->initModify();
		$this->initModifyArray(self::$SKILL);
		$this->initModifyArray(self::$ATTRIBUTE);
		$this->initModifyArray(self::$KNOWLEDGE);
		
		$this->modifyRace();
		$this->modifyGender();
		if (!$this->hasEquipment('weapon')) { $this->modifyItem(Item_Fists::staticFists()); }
		$this->modifyItems($this->sr4_equipment);
		$this->modifyItems($this->sr4_cyberware);
		$this->modifyInventory();
		
		$this->modifyMaxima();
		$this->modifyEffects();
	}
	
	private function modifyInventory()
	{
		foreach ($this->sr4_inventory as $item)
		{
			$this->sr4_data_modified['weight'] += $item->getItemWeight();
		}
	}
	
	private function initModify()
	{
		$this->sr4_data_modified = array(
			'weight' => 0,
			'max_weight' => 0,
			'attack' => 0,
			'defense' => 0,
			'min_dmg' => 0,
			'max_dmg' => 0,
			'marm' => 0,
			'farm' => 0,
//			'hp' => $this->getVar('sr4pl_hp'),
//			'mp' => $this->getVar('sr4pl_mp'),
			'max_hp' => 0,
			'max_mp' => 0,
			'base_hp' => $this->getVar('sr4pl_base_hp'),
			'base_mp' => $this->getVar('sr4pl_base_mp'),
			'hp_per_body' => self::HP_PER_BODY,
			'mp_per_magic' => self::MP_PER_MAGIC,
			'level' => $this->getVar('sr4pl_level'),
			
			'sick' => 0,
			'tired' => 0,
			'hunger' => 0,
			'thirst' => 0,
			'alcohol' => 0,
			'poisoned' => 0,
		);
		$this->initModifyArray(self::$SKILL);
		$this->initModifyArray(self::$ATTRIBUTE);
		$this->initModifyArray(self::$KNOWLEDGE);
		foreach (SR_Spell::getSpells() as $name => $spell)
		{
			$this->sr4_data_modified[$name] = -1;
		}
		foreach (explode(',', $this->getVar('sr4pl_known_spells')) as $data)
		{
			if ($data === '') {
				continue;
			}
			$data = explode(':', $data);
			$this->sr4_data_modified[$data[0]] = $data[1];
		}
	}
	
	private function modifyMaxima()
	{
		$this->sr4_data_modified['max_hp'] += $this->get('body') * $this->get('hp_per_body') + $this->get('base_hp') + self::BASE_HP;
		$this->sr4_data_modified['max_mp'] += $this->get('magic') * $this->get('mp_per_magic') + $this->get('base_mp') + self::BASE_MP;
		$this->sr4_data_modified['max_weight'] += $this->get('strength') * self::WEIGHT_PER_STRENGTH + self::WEIGHT_BASE;
		
		$this->applyModifiers($this->getWeapon()->getItemModifiersW($this));
		
		$this->sr4_data_modified['defense'] += $this->get('quickness') / 2;
		
		$this->applyModifiers($this->getNPCModifiersB());
	}
	
	private function initModifyArray(array $fields)
	{
		foreach ($fields as $f)
		{
			$this->sr4_data_modified[$f] = $this->gdo_data['sr4pl_'.$f];
		}
	}
	
	private function modifyRace()
	{
		$this->applyModifiers(self::$RACE[$this->getRace()]);
	}
	
	private function modifyGender()
	{
		$this->applyModifiers(self::$GENDER[$this->getGender()]);
	}
	
	private function modifyItems(array $items)
	{
		foreach ($items as $item)
		{
			$this->modifyItem($item);
		}
	}
	
	private function modifyItem(SR_Item $item)
	{
		$this->applyModifiers($item->getItemModifiers($this));
	}
	
	private function modifyEffects()
	{
		$changed = false;
		foreach ($this->sr4_effects as $i => $effect)
		{
			$effect instanceof SR_Effect;
			if ($effect->isOver()) {
				unset($this->sr4_effects[$i]);
				$changed = true;
			}
			else {
				$this->applyModifiers($effect->getModifiers($this));
			}
		}
		if ($changed === true) {
			$this->updateEffects();
		}
	}
	
	private function applyModifiers(array $modifiers)
	{
		foreach ($modifiers as $key => $value)
		{
			if ($key === 'hp') {
				$this->healHP($value);
			} elseif ($key === 'mp') {
				$this->healMP($value);
			} else {
				$this->sr4_data_modified[$key] += $value;
			}
		}
	}
	
	##############
	### Spells ###
	##############
	public function getSpellLevel($spellname)
	{
		return $this->sr4_data_modified[$spellname];
	}
	
	public function getSpellData()
	{
		$back = array();
		foreach(explode(',', trim($this->getVar('sr4pl_known_spells'), ',')) as $d)
		{
			if ($d !== '')
			{
				list($name, $lvl) = explode(':', $d);
				$back[$name] = $lvl;
			}
		}
		return $back;
	}
	
	private function saveSpellData(array $data)
	{
		$s = '';
		foreach ($data as $name => $level)
		{
			$s .= sprintf(',%s:%s', $name, $level);
		}
		$this->saveVar('sr4pl_known_spells', $s.',');
	}
	
	public function getSpellBaseLevel($spellname)
	{
		$data = $this->getSpellData();
		return isset($data[$spellname]) ? $data[$spellname] : -1;
	}
	
	public function levelupSpell($spellname, $by=1)
	{
		$data = $this->getSpellData();
		if (isset($data[$spellname])) {
			$data[$spellname] += $by;
		} else {
			$data[$spellname] = 0;
		}
		$this->saveSpellData($data);
	}
	
	#################
	### Equipment ###
	#################
	public function getWeapon()
	{
		return isset($this->sr4_equipment['weapon']) ? $this->sr4_equipment['weapon'] : Item_Fists::staticFists();
	}
	
	public function hasEquipment($field)
	{
		return isset($this->sr4_equipment[$field]);
	}
	
	public function getEquipment($field)
	{
		return $this->sr4_equipment[$field];
	}
	
	public function getAllEquipment($with_fists=true)
	{
		$back = array();
		if (!$this->hasEquipment('weapon')) {
			$back['weapon'] = Item_Fists::staticFists();
		}
		return array_merge($back, $this->sr4_equipment);
	}
	
	public function equip(SR_Equipment $item)
	{
		unset($this->sr4_inventory[$item->getID()]);
		$this->updateInventory();
		$this->updateEquipment($item->getItemType(), $item);
	}
	
	public function unequip(SR_Equipment $item)
	{
		$field = $item->getItemType();
		$itemid = $item->getID();
		# Can unequip?
		if ( (false === ($item = $this->getEquipment($field))) || ($item->getID() !== $itemid) ) {
			return false;
		}
		$this->sr4_inventory[$itemid] = $item;
		$this->updateInventory();
		$this->updateEquipment($field, NULL);
	}
	
	public function updateEquipment($field, $item=NULL)
	{
		if ($item === NULL)
		{
			$itemid = '0';
			unset($this->sr4_equipment[$field]);
		}
		else
		{
			$this->sr4_equipment[$field] = $item;
			$itemid = $item->getID();
		}
		
		return $this->saveVar('sr4pl_'.$field, $itemid);
	}
	
	###############
	### Effects ###
	###############
	public function getEffects()
	{
		return $this->sr4_effects;
	}
	
	public function addEffects($effect)
	{
		foreach (func_get_args() as $effect)
		{
			$this->addEffect($effect);
		}
		$this->modify();
		$this->updateEffects();
	}
	
	private function addEffect(SR_Effect $effect)
	{
		$this->sr4_effects[] = $effect;
	}
	
	private function updateEffects()
	{
		if (count($this->sr4_effects) === 0) {
			return $this->saveVar('sr4pl_effects', NULL);
		}
		else {
			return $this->saveVar('sr4pl_effects', serialize($this->sr4_effects));
		}
	}
	
	public function effectsTimer()
	{
		$changed = false;
		$modified = false;
		foreach ($this->sr4_effects as $i => $effect)
		{
			$effect instanceof SR_Effect;
			if ($effect->isOver())
			{
				unset($this->sr4_effects[$i]);
				$modified = true;
				$changed = true;
			}
			
			elseif ($effect->getMode() === SR_Effect::MODE_REPEAT) {
				$modified = true;
			}
		}
		
		if ($changed === true)
		{
			$this->updateEffects();
		}
		
		if ($modified === true)
		{
			$this->modify();
		}
	}
	
	############
	### Item ###
	############
	/**
	 * @param string $itemname
	 * @return SR_Item
	 */
	public function getItem($itemname)
	{
		$itemname = strtolower($itemname);
		
		# ex 1
		if (is_numeric($itemname)) {
			return $this->getItemByInvID($itemname);
		}
		
		# ex eq
		if (array_key_exists($itemname, self::$EQUIPMENT)) {
			$itemname = self::$EQUIPMENT[$itemname];
		}
		
		if (in_array($itemname, self::$EQUIPMENT, true)) {
			if ($this->hasEquipment($itemname)) {
				return $this->getEquipment($itemname);
			}
			elseif ($itemname === 'weapon') {
				return Item_Fists::staticFists();
			} 
		}
		
		return $this->getItemByName($itemname);
	}
	
	public function getBankItemByID($id)
	{
		return $this->getItemByID($this->getBankSorted(), $id, $this->getBankItems());
	}
	
	
	public function getItemByInvID($invid)
	{
		return $this->getItemByID($this->getInventorySorted(), $invid, $this->sr4_inventory);
	}
	
	public function getItemByID(array $items, $id, array $items2)
	{
		$id = (int)$id;
		if ($id > count($items) || $id < 1) {
			return false;
		}
		$back = array_slice($items, $id-1, 1);
		$back = array_shift($back);
		return $items2[$back[1]];
	}
	
	public function getAllItems()
	{
		return array_merge($this->sr4_cyberware, $this->sr4_inventory, $this->sr4_equipment);
	}
	
	public function getItemByItemID($itemid)
	{
		$itemid = (int) $itemid;
		foreach ($this->getAllItems() as $item)
		{
			if ($item->getID() === $itemid) {
				return $item;
			}
		}
		return false;
	}
	
	/**
	 * @param string $itemname
	 * @return SR_Item
	 */
	public function getItemByName($itemname)
	{
		return $this->getItemByNameB($itemname, $this->getAllItems());
	}
	
	public function getBankItemByName($itemname)
	{
		return $this->getItemByNameB($itemname, $this->getBankItems());
	}
	
	/**
	 * @param string $itemname
	 * @return SR_Item
	 */
	public function getInvItem($invid)
	{
		if (is_numeric($invid)) {
			return $this->getItemByID($this->getInventorySorted(), $invid, $this->sr4_inventory);
		} else {
			return $this->getInvItemByName($invid);
		}
	}
	
	/**
	 * @param string $itemname
	 * @return SR_Item
	 */
	public function getInvItemByName($itemname)
	{
		return $this->getItemByNameB($itemname, $this->sr4_inventory);
	}
	
	public function getItemByNameB($itemname, array $items)
	{
		$itemname = strtolower($itemname);
		foreach (array_reverse($items) as $item)
		{
			if (strtolower($item->getItemName()) === $itemname)
			{
				return $item;
			}
		}
		return false;
	}
	
	#################
	### Cyberware ###
	#################
	public function getCyberware()
	{
		return $this->sr4_cyberware;
	}
	
	public function hasCyberware($itemname)
	{
		return $this->getCyberwareByName($itemname) !== false;
	}
	
	public function getCyberwareByID($id)
	{
		$id = (int) $id;
		$cyberware = $this->sr4_cyberware;
		if ($id < 1 || $id > count($cyberware)) {
			return false;
		}
		$back = array_slice($cyberware, $id-1, 1, false);
		return $back[0];
	}
	
	public function getCyberwareByName($itemname)
	{
		$itemname = strtolower($itemname);
		foreach ($this->sr4_cyberware as $item)
		{
			if ($itemname === strtolower($item->getItemName()))
			{
				return $item;
			}
		}
		return false;
		
	}
	
	public function addCyberware(SR_Cyberware $item)
	{
		$item->saveVar('sr4it_uid', $this->getID());
		$this->sr4_cyberware[$item->getID()] = $item;
		return $this->updateCyberware();
	}
	
	private function updateCyberware()
	{
		if (false === $this->updateItemArray('sr4pl_cyberware', $this->sr4_cyberware)) {
			return false;
		}
		$this->setOption(self::CYBER_DIRTY|self::STATS_DIRTY, true);
		$this->modify();
		return true;
	}
	
	public function removeCyberware(SR_Cyberware $item)
	{
		foreach ($this->sr4_cyberware as $id => $i)
		{
			if ($item->getItemName() === $i->getItemName())
			{
				unset($this->sr4_cyberware[$id]);
				return $this->updateCyberware();
			}
		}
		return false;
	}
	
	#################
	### Inventory ###
	#################
	public function getInventorySorted()
	{
		return $this->getItemsSorted($this->sr4_inventory);
	}
	
	public function getBankSorted()
	{
		return $this->getItemsSorted($this->getBankItems());
	}
	
	private function getItemsSorted(array $items)
	{
		$temp = array();
		foreach ($items as $itemid => $item)
		{
			$name = $item->getItemName();
			if (isset($temp[$name])) {
				$temp[$name][0] += $item->getAmount();
				$temp[$name][1] = $itemid;
			} else {
				$temp[$name] = array($item->getAmount(), $itemid);
			}
		}
		return $temp;
	}
	
	/**
	 * Give items to a player. Argument(s) can be array(s) and/or items.
	 */
	public function giveItems()
	{
		$message = '';
		
		$args = func_get_args();
		$items = array();
		foreach ($args as $arg)
		{
			if (is_array($arg)) {
				$items = array_merge($items, $arg);
			} else {
				$items[] = $arg;
			}
		}
		foreach ($items as $item)
		{
			$this->giveItem($item);
			$message .= sprintf(', %s', $item->getItemName());
		}
		if ($message !== '')
		{
			$this->updateInventory();
			$this->getParty()->message($this, 'Received item(s): '.substr($message,2 ));
		}
	}
	
	private function giveItem(SR_Item $item)
	{
		if ($item->isItemStackable())
		{
			if (false !== ($other = $this->getItem($item->getItemName()))) {
				$other->increase('sr4it_amount', $item->getAmount());
				$item->delete();
				return true;
			}
		}
		$item->saveVar('sr4it_uid', $this->getID());
		$this->sr4_inventory[$item->getID()] = $item;
		return true;
	}
	
	private function updateInventory()
	{
		if (false === $this->updateItemArray('sr4pl_inventory', $this->sr4_inventory)) {
			return false;
		}
		$this->setOption(self::INV_DIRTY, true);
		$this->modify();
		return true;
	}
	
	private function updateItemArray($field, array $items)
	{
		return $this->saveVar($field, implode(',', array_keys($items)));
	}
	
	public function removeFromInventory(SR_Item $item)
	{
		$id = $item->getID();
		if (!(isset($this->sr4_inventory[$id]))) {
			return false;
		}
		unset($this->sr4_inventory[$id]);
		$this->updateInventory();
		return true;
	}
	
	public function removeItem(SR_Item $item)
	{
		if ($item->isEquipped($this)) {
			$this->unequip($item);
		}
		return $this->removeFromInventory($item);
	}
	
	############
	### Bank ###
	############
	public function putInBank(SR_Item $item)
	{
		$bank = $this->getBankItems();
		$bank[$item->getID()] = $item;
		return $this->updateBank($bank);
	}
	
	private function updateBank(array $items)
	{
		$this->updateItemArray('sr4pl_bank', $items);
	}
	
	public function getBankItems()
	{
		$bank = array();
		foreach (explode(',', $this->getVar('sr4pl_bank')) as $itemid)
		{
			$itemid = (int) $itemid;
			if (false !== ($item = SR_Item::getByID($itemid)))
			{
				$bank[$itemid] = $item;
			}
		}
		return $bank;
	}
	
	public function removeFromBank($itemname)
	{
		if (is_numeric($itemname))
		{
			$item = $this->getBankItemByID($itemname);
		}
		else
		{
			$item = $this->getBankItemByName($itemname);
		}
		
		if ($item === false) {
			return false;
		}
		
		$bank = $this->getBankItems();
		unset($bank[$item->getID()]);
		$this->updateBank($bank);
		$this->giveItem($item);
		$this->updateInventory();
		$this->modify();
		return $item;
	}
	
	#############
	### Nuyen ###
	#############
	public function hasNuyen($ny)
	{
		return $this->getBase('nuyen') >= $ny;
	}
	
	public function pay($nuyen)
	{
		if (0 === ($nuyen = (int) $nuyen)) {
			return true;
		}
		if ($nuyen > $this->getBase('nuyen')) {
			return false;
		}
		return $this->alterField('nuyen', -$nuyen);
	}
	
	public function alterField($field, $by)
	{
		return $this->updateField($field, $this->getBase($field)+$by);
	}
	
	###############
	### Known X ###
	###############
	public function getKnowledge($field)
	{
		return $this->getVar('sr4pl_known_'.$field);
	}
	
	public function getKnowledgeByID($field, $id)
	{
		$k = explode(',', trim($this->getVar('sr4pl_known_'.$field), ','));
		$id = (int)$id;
		if ($id < 1 || $id > count($k)) {
			return false;
		}
		return $k[$id-1];
	}
	
	public function hasKnowledge($field, $knowledge)
	{
		return stripos($this->getKnowledge($field), ",$knowledge,") !== false;
	}
	
	public function giveKnowledge($field, $knowledge)
	{
		static $txt = array('places' => 'location','words' => 'word');
		$args = func_get_args();
		$field = array_shift($args);
		foreach ($args as $knowledge)
		{
			if ($this->hasKnowledge($field, $knowledge)) {
				continue;
			}
			$k = $this->getKnowledge($field);
			if (false === $this->saveVar('sr4pl_known_'.$field, $k.$knowledge.',')) {
				return false;
			}
			
			if ($field === 'places') {
				$this->setOption(self::LOCATION_DIRTY, true);
			}
			elseif ($field === 'words') {
				$this->setOption(self::WORDS_DIRTY, true);
			}
			
			$this->message(sprintf('You know a new %s: %s.', $txt[$field], $knowledge));
		}
		return true;
	}
	
	public function removeKnowledge($field, $knowledge)
	{
		$knowledge = strtolower($knowledge);
		if (!$this->hasKnowledge($field, $knowledge)) {
			return true;
		}
		$k = $this->getKnowledge($field);
		if (false === $this->saveVar('known_'.$field, str_ireplace(",$knowledge,", ',', $k))) {
			return false;
		}
		$this->message(sprintf('You forget about the %s: %s.', $field, $knowledge));
		return true;
	}
	
	############
	### Heal ###
	############
	public function healHP($gain)
	{
		return $this->heal('hp', $gain);
	}

	public function healMP($gain)
	{
		return $this->heal('mp', $gain);
	}

	private function heal($field, $gain)
	{
		$old = $this->getBase($field);
		$max = $this->get('max_'.$field);
		$new = Common::clamp($old+$gain, 0.0, $max);
		$this->setOption(SR_Player::STATS_DIRTY, true);
		$this->updateField($field, $new);
		return $new-$old;
	}
	
	public function dealDamage($damage)
	{
		return $this->healHP(-$damage);
	}
	
	#############
	### XP/NY ###
	#############
	public function getXPPerKarma()
	{
		return $this->getBase('level') * self::XP_PER_KARMA_RAISE + self::XP_PER_KARMA;
	}
	
	public function getXPPerLevel()
	{
		return $this->getBase('level') * self::XP_PER_LEVEL_RAISE + self::XP_PER_LEVEL;
	}
	
	public function giveKarma($karma)
	{
		if (false === ($this->alterField('karma', $karma))) {
			return false;
		}
		if (false === ($this->alterField('karma_total', $karma))) {
			return false;
		}
		return true;
	}
	
	public function giveXP($xp)
	{
		if (false === ($this->alterField('xp', $xp))) {
			return false;
		}
		if (false === ($this->alterField('xp_total', $xp))) {
			return false; 
		}
		if (false === ($this->alterField('xp_level', $xp))) {
			return false;
		}
		
		$level = 0;
		while ($this->getBase('xp_level') >= ($xppl = $this->getXPPerLevel()))
		{
			$this->alterField('level', 1);
			$this->alterField('xp_level', -$xppl);
			$level++;
		}
		if ($level > 0)
		{
			$this->getParty()->message($this, sprintf(' reached level %s(+%d)', $this->getBase('level'), $level));
		}
		
		$karma = 0;
		while ($this->getBase('xp') >= ($xppk = $this->getXPPerKarma()))
		{
			$this->giveKarma(1);
			$this->alterField('xp', -$xppk);
			$karma++;
		}
		
		if ($karma > 0)
		{
			$this->message(sprintf('You now have %d(+%d) karma.', $this->getBase('karma'), $karma));
		}
	}
	
	public function giveNuyen($nuyen)
	{
		return $this->alterField('nuyen', $nuyen);
	}
	
	public function resetXP()
	{
		$xp = $this->getBase('xp');
		$this->alterField('xp', -$xp);
		$this->alterField('xp_level', -$xp);
		$this->alterField('xp_total', -$xp);
	}
	
	##############
	### Update ###
	##############
	public function updateField($field, $value)
	{
		if (false === ($this->saveVar('sr4pl_'.$field, $value))) {
			return false;
		}
//		$this->sr4_data_modified[$field] = $value;
		return true;
	}
	
	##############
	### Combat ###
	##############
	
	private $combat_eta = 0;
	private $combat_stack = '';
	private $combat_target = 0;
	
	public function calcBusyTime($seconds)
	{
		$q = $this->get('quickness');
//		$sq = round(sqrt($seconds));
		$seconds -= $q / 3;
		$seconds += rand(1, 10) - 5;
		return Common::clamp($seconds, 5);
	}
	
	public function busy($seconds)
	{
		$seconds = $this->calcBusyTime($seconds);
		$this->combat_eta = Shadowrun4::getTime() + $seconds;
		return $seconds;
	}
	
	public function isBusy()
	{
		return $this->combat_eta > Shadowrun4::getTime();
	}
	
	private function cmdAttackRandom()
	{
		if (false === ($ep = $this->getEnemyParty())) {
			return '#';
		}
		return sprintf('# %s', rand(1, $ep->getMemberCount()));
	}
	
	public function combatPush($message)
	{
		echo 'Pushing '.$message.' on combat stack.'.PHP_EOL;
		$this->combat_stack = $message;
	}
		
	public function combatTimer()
	{
		if ($this->isBusy()) {
			return;
		}
		
		if ($this->combat_stack === '') {
			$this->combat_stack = $this->cmdAttackRandom();
		}
		
		echo sprintf('Executing combatTimer() stack: '.$this->combat_stack.PHP_EOL);
		$result = Shadowcmd::onExecute($this, $this->combat_stack);
		
		if ($this->keepCombatStack($result) === false) {
			$this->combat_stack = '';
		}
	}
	
	private function keepCombatStack($bool)
	{
		if ($bool === false) {
			return false;
		}
		$c = strtolower($this->combat_stack);
		if (Common::startsWith($c, '#')) {
			return true;
		}
		if (Common::startsWith($c, 'attack')) {
			return true;
		}
		if (Common::startsWith($c, 'fl')) {
			return true;
		}
		
		echo sprintf('cleared the combat stack.').PHP_EOL;
		
		return false;
	}
	
	public function getLootXP()
	{
		return $this->getBase('strength') / 2 + ($this->getBase('quickness') / 4) + 1;
	}
	
	public function getLootNuyen()
	{
		return $this->getBase('nuyen') / 8;
	}
	
	public function gotKilledBy(SR_Player $killer)
	{
		if ($killer->isHuman()) {
			$this->gotKilledByHuman($killer);
		} else {
			$this->gotKilledByNPC($killer);
		}
		$this->respawn();
	}
	
	public function gotKilledByNPC(SR_NPC $killer)
	{
//		Lamb_Log::log(__METHOD__);
		# Loose an item.
		$items = array_merge($this->sr4_equipment, $this->sr4_inventory);
		if (0 !== ($rand = rand(0, count($items))))
		{
			shuffle($items);
			$item = array_pop($items);
			$item instanceof SR_Item;
			if ($item->isEquipped($this))
			{
				$this->unequip($item);
			}
			$this->removeFromInventory($item);
			$killer->giveItems($item);
			$this->message(sprintf('You lost your %s.', $item->getItemName()));
		}
	}

	public function gotKilledByHuman(SR_Player $player)
	{
		Lamb_Log::log(__METHOD__);
	}
}
?>