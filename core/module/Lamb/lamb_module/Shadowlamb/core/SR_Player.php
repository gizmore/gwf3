<?php
class SR_Player extends GDO
{
	const MAX_SD = 20.0;
	const MAX_WEIGHT_MALUS = 0.25; # 25%
		
	const BASE_HP = 4;
	const BASE_HP_NPC = 1;
	const BASE_MP = 0;
	const HP_PER_BODY = 2.5;
	const MP_PER_MAGIC = 5;
	const MP_PER_CASTING = 5;
	const HP_REFRESH_MULTI = 0.03;
	const MP_REFRESH_MULTI = 0.02;
	const HP_REFRESH_TIMER = 300;
	const MP_REFRESH_TIMER = 240;
	
	const XP_PER_KARMA = 4;
	const XP_PER_KARMA_RAISE = 0.5;
	const XP_PER_LEVEL = 30;
	const XP_PER_LEVEL_RAISE = 9;
	
	const WEIGHT_BASE = 6500;
	const WEIGHT_PER_STRENGTH = 1500;
	
	# Human Starter
	const START_HP = 4;
	const START_NUYEN = 0;
	
	# Options
	const CREATED = 0x00001;
	const HELP = 0x00002;
	const NOTICE = 0x00000;
	const PRIVMSG = 0x00004;
	const RUNNING_MODE = 0x00008;
	const BOTTING = 0x10000;
	const DEAD = 0x20000; # PERM DEAD
	const SILENCE = 0x40000;
	const LOCKED = 0x100000;
	const PLAYER_BOT = 0x200000;
	const NO_RL = 0x400000; # No RequestLeader
	
	# Timing
	const FIGHT_INIT_BUSY = 12;
	const GIVE_TIME = 60;
	const UNEQUIP_TIME = 20;
	const FORWARD_TIME = 30;
	const BACKWARD_TIME = 45;
	
	# WWW hack
	const WWW_OUT = 0x00010;
	const INV_DIRTY = 0x00020;
	const CMD_DIRTY = 0x00040;
	const STATS_DIRTY = 0x00080;
	const EQ_DIRTY = 0x00100;
	const PARTY_DIRTY = 0x00200;
	const LOCATION_DIRTY = 0x00400;
	const CYBER_DIRTY = 0x00800;
	const WORDS_DIRTY = 0x01000;
	const RESPONSE_ITEMS = 0x02000;
	const RESPONSE_PLAYERS = 0x04000;
	const MOUNT_DIRTY = 0x80000;
	const LOOK_DIRTY = 0x100000;
	const DIRTY_FLAGS = 0x187fe0;

	public static $ALL = NULL; # see init
	public static $REV_ALL = NULL; # see init
	public static $CONDITIONS = array('frozen','sick','tired','hunger','thirst','alc','poisoned','caf','happy','weight');
//	public static $COMBAT_STATS = array('elep'=>'elephants','mxhp'=>'max_hp','mxwe'=>'max_weight','atk'=>'attack','def'=>'defense','mndmg'=>'min_dmg','mxdmg'=>'max_dmg','marm'=>'marm','farm'=>'farm');
//	public static $MAGIC_STATS = array('orca'=>'orcas','mxmp'=>'max_mp','satk'=>'spellatk','sdef'=>'spelldef');
	public static $COMBAT_STATS = array('mxhp'=>'max_hp','mxmp'=>'max_mp','mxwe'=>'max_weight','atk'=>'attack','def'=>'defense','mndmg'=>'min_dmg','mxdmg'=>'max_dmg','marm'=>'marm','farm'=>'farm');
	public static $MAGIC_STATS = array();
	public static $MOUNT_STATS = array('lock'=>'lock','tran'=>'transport','tune'=>'tuneup');
	public static $ATTRIBUTE = array('bo'=>'body','ma'=>'magic','st'=>'strength','qu'=>'quickness','wi'=>'wisdom','in'=>'intelligence','ch'=>'charisma','lu'=>'luck','re'=>'reputation','es'=>'essence');
//	public static $SKILL = array('mel'=>'melee','nin'=>'ninja','fir'=>'firearms','bow'=>'bows','pis'=>'pistols','sho'=>'shotguns','smg'=>'smgs','hmg'=>'hmgs','com'=>'computers','ele'=>'electronics','bio'=>'biotech','neg'=>'negotiation','sha'=>'sharpshooter','sea'=>'searching','loc'=>'lockpicking','thi'=>'thief');
	public static $SKILL = array('mel'=>'melee','nin'=>'ninja','swo'=>'swordsman','vik'=>'viking','fir'=>'firearms','bow'=>'bows','pis'=>'pistols','sho'=>'shotguns','smg'=>'smgs','hmg'=>'hmgs','com'=>'computers','ele'=>'electronics','bio'=>'biotech','neg'=>'negotiation','sha'=>'sharpshooter','sea'=>'searching','loc'=>'lockpicking','thi'=>'thief','orca'=>'orcas','elep'=>'elephants','sat'=>'spellatk','sde'=>'spelldef','cas'=>'casting','alc'=>'alchemy');
	public static $KNOWLEDGE = array('inc'=>'indian_culture','inl'=>'indian_language','mat'=>'math','cry'=>'crypto','ste'=>'stegano');
	public static $EQUIPMENT = array('am'=>'amulet','ar'=>'armor','bo'=>'boots','ea'=>'earring','he'=>'helmet','le'=>'legs','ri'=>'ring','sh'=>'shield','we'=>'weapon','mo'=>'mount');
	public static $WORDS = array('Renraku','Hello','Yes','No','Shadowrun','Hire','Blackmarket','Cyberware','Magic','Redmond','Seattle','Delaware');
	public static $NPC_RACES = array('droid','dragon');
	
	/**
	 * Bonus values for races.
	 */
	public static $RACE = array(
		'fairy' =>    array('body'=>0,'magic'=> 5,'strength'=>-2,'quickness'=>3,'wisdom'=>4,'intelligence'=>4,'charisma'=> 4,'luck'=>3),
		'elve' =>     array('body'=>1,'magic'=> 4,'strength'=>-1,'quickness'=>3,'wisdom'=>2,'intelligence'=>3,'charisma'=> 2,'bows'=>1),
		'halfelve' => array('body'=>1,'magic'=> 3,'strength'=> 0,'quickness'=>3,'wisdom'=>2,'intelligence'=>2,'charisma'=> 2,'bows'=>2),
		'vampire' =>  array('body'=>0,'magic'=> 3,'strength'=> 0,'quickness'=>4,'wisdom'=>2,'intelligence'=>3,'charisma'=> 1),
		'darkelve' => array('body'=>1,'magic'=> 2,'strength'=> 0,'quickness'=>3,'wisdom'=>2,'intelligence'=>2,'charisma'=> 2,'bows'=>2),
		'woodelve' => array('body'=>1,'magic'=> 1,'strength'=> 0,'quickness'=>3,'wisdom'=>1,'intelligence'=>2,'charisma'=> 2,'bows'=>2),
		'human' =>    array('body'=>2,'magic'=> 0,'strength'=> 0,'quickness'=>3,'wisdom'=>1,'intelligence'=>2,'charisma'=> 2),
		'gnome' =>    array('body'=>2,'magic'=> 0,'strength'=> 0,'quickness'=>3,'wisdom'=>1,'intelligence'=>2,'charisma'=> 1,'luck'=>1),
		'dwarf' =>    array('body'=>3,'magic'=> 0,'strength'=> 1,'quickness'=>2,'wisdom'=>1,'intelligence'=>2,'charisma'=> 1,'luck'=>1),
		'halfork' =>  array('body'=>3,'magic'=>-1,'strength'=> 1,'quickness'=>2,'wisdom'=>1,'intelligence'=>2,'charisma'=> 1),
		'halftroll'=> array('body'=>3,'magic'=>-2,'strength'=> 2,'quickness'=>2,'wisdom'=>0,'intelligence'=>1,'charisma'=> 0),
		'ork' =>      array('body'=>4,'magic'=>-3,'strength'=> 3,'quickness'=>1,'wisdom'=>1,'intelligence'=>1,'charisma'=> 0),
		'troll' =>    array('body'=>4,'magic'=>-4,'strength'=> 4,'quickness'=>0,'wisdom'=>0,'intelligence'=>0,'charisma'=> 0,'essence'=>-0.2),
		'gremlin' =>  array('body'=>4,'magic'=>-5,'strength'=> 3,'quickness'=>1,'wisdom'=>0,'intelligence'=>0,'charisma'=>-1,'reputation'=>2,'essence'=>-0.5),
		#NPC
		'droid' =>    array('body'=>0,'magic'=>0, 'strength'=> 0,'quickness'=>0,'wisdom'=>0,'intelligence'=>0,'charisma'=>-3,'reputation'=>0, 'essence'=>0),
		'dragon' =>   array('body'=>8,'magic'=>8, 'strength'=> 8,'quickness'=>0,'wisdom'=>8,'intelligence'=>8,'charisma'=> 0,'reputation'=>12,'essence'=>2),
	);
	
	/**
	 * Base values for races.
	 */
	public static $RACE_BASE = array(
		'fairy' =>    array('base_hp'=>3, 'base_mp'=>6, 'body'=>1,'magic'=> 1,'strength'=> 0,'quickness'=>3,'wisdom'=> 1,'intelligence'=> 4,'charisma'=> 3,'luck'=>1,'height'=>120,'age'=>  20,'bmi'=> 40), # fairy
		'elve' =>     array('base_hp'=>4, 'base_mp'=>4, 'body'=>1,'magic'=> 1,'strength'=> 0,'quickness'=>3,'wisdom'=> 0,'intelligence'=> 2,'charisma'=> 1,'luck'=>0,'height'=>140,'age'=>  32,'bmi'=> 50), # elve
		'halfelve' => array('base_hp'=>5, 'base_mp'=>2, 'body'=>1,'magic'=>-1,'strength'=> 1,'quickness'=>2,'wisdom'=> 0,'intelligence'=> 1,'charisma'=> 1,'luck'=>0,'height'=>160,'age'=>  28,'bmi'=> 60), # halfelve
		'vampire' =>  array('base_hp'=>5, 'base_mp'=>3, 'body'=>0,'magic'=> 1,'strength'=> 2,'quickness'=>2,'wisdom'=> 0,'intelligence'=> 2,'charisma'=> 0,'luck'=>0,'height'=>185,'age'=> 140,'bmi'=> 70), # vampire
		'darkelve' => array('base_hp'=>5, 'base_mp'=>1, 'body'=>1,'magic'=>-1,'strength'=> 2,'quickness'=>2,'wisdom'=> 0,'intelligence'=> 1,'charisma'=> 1,'luck'=>0,'height'=>170,'age'=>  26,'bmi'=> 70), # darkelve
		'woodelve' => array('base_hp'=>5, 'base_mp'=>2, 'body'=>1,'magic'=>-1,'strength'=> 1,'quickness'=>2,'wisdom'=> 0,'intelligence'=> 1,'charisma'=> 1,'luck'=>0,'height'=>180,'age'=>  24,'bmi'=> 75), # woodelve
		'human' =>    array('base_hp'=>6, 'base_mp'=>0, 'body'=>2,'magic'=>-1,'strength'=> 1,'quickness'=>1,'wisdom'=> 0,'intelligence'=> 0,'charisma'=> 0,'luck'=>0,'height'=>185,'age'=>  30,'bmi'=> 80), # human
		'gnome' =>    array('base_hp'=>6, 'base_mp'=>0, 'body'=>2,'magic'=>-1,'strength'=> 1,'quickness'=>1,'wisdom'=> 0,'intelligence'=> 0,'charisma'=> 0,'luck'=>0,'height'=>130,'age'=>  32,'bmi'=> 55), # gnome
		'dwarf' =>    array('base_hp'=>6, 'base_mp'=>0, 'body'=>2,'magic'=>-1,'strength'=> 1,'quickness'=>1,'wisdom'=> 0,'intelligence'=> 0,'charisma'=> 0,'luck'=>0,'height'=>145,'age'=>  34,'bmi'=> 65), # dwarf
		'halfork' =>  array('base_hp'=>7, 'base_mp'=>-1,'body'=>2,'magic'=>-1,'strength'=> 2,'quickness'=>1,'wisdom'=> 0,'intelligence'=> 0,'charisma'=> 0,'luck'=>0,'height'=>195,'age'=>  24,'bmi'=> 80), # halfork
		'halftroll'=> array('base_hp'=>8, 'base_mp'=>-2,'body'=>3,'magic'=>-1,'strength'=> 2,'quickness'=>0,'wisdom'=> 0,'intelligence'=> 0,'charisma'=> 0,'luck'=>0,'height'=>200,'age'=>  24,'bmi'=> 90), # halftroll
		'ork' =>      array('base_hp'=>9, 'base_mp'=>-3,'body'=>3,'magic'=>-2,'strength'=> 3,'quickness'=>0,'wisdom'=> 0,'intelligence'=> 0,'charisma'=> 0,'luck'=>0,'height'=>205,'age'=>  22,'bmi'=>100), # ork
		'troll' =>    array('base_hp'=>10,'base_mp'=>-4,'body'=>3,'magic'=>-2,'strength'=> 3,'quickness'=>0,'wisdom'=> 0,'intelligence'=> 0,'charisma'=> 0,'luck'=>0,'height'=>215,'age'=>  18,'bmi'=>110), # troll
		'gremlin' =>  array('base_hp'=>11,'base_mp'=>-6,'body'=>1,'magic'=>-3,'strength'=> 0,'quickness'=>2,'wisdom'=> 0,'intelligence'=> 0,'charisma'=> 0,'luck'=>0,'height'=> 50,'age'=>   1,'bmi'=> 10), # gremlin
		#NPC
		'droid' =>    array('base_hp'=>0, 'base_mp'=>0, 'body'=>0,'magic'=> 0,'strength'=> 0,'quickness'=>0,'wisdom'=> 0,'intelligence'=> 0,'charisma'=> 0,'luck'=>0,'height'=>160,'age'=>   2,'bmi'=> 70), # droid
		'dragon' =>   array('base_hp'=>0, 'base_mp'=>0, 'body'=>8,'magic'=> 8,'strength'=>12,'quickness'=>3,'wisdom'=>12,'intelligence'=>12,'charisma'=> 0,'luck'=>0,'height'=>500,'age'=>6000,'bmi'=>400), # dragon
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
			'sr4pl_sid' => array(GDO::UINT, 0),
			'sr4pl_partyid' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4pl_classname' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 63),
			'sr4pl_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 63),
			'sr4pl_title' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 63),
			'sr4pl_race' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, 'human', 63),
			'sr4pl_gender' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, 'male', 63),
			'sr4pl_age' => array(GDO::UINT, GDO::NULL), # age in years
			'sr4pl_bmi' => array(GDO::UINT, GDO::NULL), # own weight in gramm
			'sr4pl_height' => array(GDO::UINT, GDO::NULL), # height in cm
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
			'sr4pl_bounty' => array(GDO::UINT, 0),
			'sr4pl_bounty_done' => array(GDO::UINT, 0),
			'sr4pl_quests_done' => array(GDO::UINT, 0),
		
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
			'sr4pl_mount_inv' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4pl_cyberware' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			# Effects
			'sr4pl_effects' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			# Vars
			'sr4pl_const_vars' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4pl_combat_ai' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4pl_game_ai' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
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
	public function getUID() { return $this->getUser()->getID(); }
	public function getServerID() { return $this->getVar('sr4pl_sid'); }
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
	public function displayName() { $u = $this->getUser(); return sprintf("\X02%s{%s}\X02", Lamb::softhyphe($u->getName()), $u->getServerID()) ; }
	public function displayNameNB() { return $this->getEnum().'-'.trim($this->displayName(), "\X02"); }
	public function getShortName() { return $this->getUser()->getName(); }
	public function isFighting() { return $this->getParty()->isFighting(); }
	public function isDead() { return $this->getHP() <= 0 || $this->isOptionEnabled(self::DEAD); }
	public function isFrozen() { return $this->get('frozen') > 0; }
	public function hasSkill($skill) { return $this->getBase($skill) > -1; }
	public function isOverloadedHalf() { return $this->get('weight') >= ($this->get('max_weight')*1.0); }
	public function isOverloadedFull() { return $this->get('weight') >= ($this->get('max_weight')*1.5); }
	public function hasFullHP() { return $this->getHP() >= $this->getMaxHP(); }
	public function hasFullMP() { return $this->getMP() >= $this->getMaxMP(); }
	public function hasFullHPMP() { return $this->hasFullHP() && $this->hasFullMP(); }
	public function getHP() { return $this->getFloat('sr4pl_hp'); }
	public function getMP() { return $this->getFloat('sr4pl_mp'); }
	public function getMaxHP() { return $this->get('max_hp'); }
	public function getMaxMP() { return $this->get('max_mp'); }
	public function getNuyen() { return $this->getFloat('sr4pl_nuyen'); }
	public function getBankNuyen() { return $this->getFloat('sr4pl_bank_nuyen'); }
	public function getDistance() { $p = $this->getParty(); return $p === false ? 0 : $p->getDistance($this); }
	public function displayNuyen() { return Shadowfunc::displayNuyen($this->getNuyen()); }
	public function displayBankNuyen() { return Shadowfunc::displayNuyen($this->getBankNuyen()); }
	public function isDrunk() { return $this->get('alc') >= (0.8 + $this->getBase('body')*0.20); }
	public function isCaffed() { return $this->get('caf') >= (1.4 + $this->getBase('body')*0.25); }
	public function getMovePerSecond() { return 1.5 + $this->get('quickness') * 0.25 + Shadowfunc::diceFloat(-0.2,+0.2,1); }
	public function isRunner() { return $this->isOptionEnabled(self::RUNNING_MODE); }
	public function needsHeal() { return ($this->getHP() / $this->getMaxHP()) <= SR_NPC::NEED_HEAL_MULTI; }
	public function needsEther() { return ($this->getMP() / $this->getMaxMP()) <= SR_NPC::NEED_ETHER_MULTI; }
	public function canHack() { return ( ($this->getBase('computers') >= 0) && ($this->hasCyberdeck()) && ($this->hasHeadcomputer()) );}
	public function isLocked() { return $this->isOptionEnabled(self::LOCKED); }
	public function getX() { return $this->getEnum() * SR_Party::X_COORD_INC + SR_Party::X_COORD_INI;}
	public function getY() { return $this->getDistance(); }
	public function hasSolvedQuest($name) { return SR_Quest::getQuest($this, $name)->isDone($this); }
	public function displayWeight() { return Shadowfunc::displayWeight($this->get('weight')); }
	public function displayMaxWeight() { return Shadowfunc::displayWeight($this->get('max_weight')); }
	
	################
	### Language ###
	################
	public function getLangISO()
	{
		$user = $this->getUser();
		if ($user instanceof Lamb_User)
		{
			return $user->getLangISO();
		}
		return 'en';
	}
	public function msg($key, $args=NULL) { return $this->message(LambModule_Shadowlamb::instance()->langISO($this->getLangISO(), $key, $args)); }
// 	public function rply($key, $args=NULL) { return Shadowrap::instance($this)->reply(LambModule_Shadowlamb::instance()->langISO($this->getLangISO(), $key, $args)); }
	public function lang($key, $args=NULL) { return LambModule_Shadowlamb::instance()->langISO($this->getLangISO(), $key, $args); }
	############
	### Enum ###
	############
	private $enum = 0;
	public function getEnum() { return $this->enum; }
	public function setEnum($enum) { $this->enum = $enum; }
	
	############
	### Race ###
	############
	public function getRaceBase() { $r = $this->getRace(); return isset(self::$RACE_BASE[$r]) ? self::$RACE_BASE[$r] : array(); }
	public function getRaceBonus() { $r = $this->getRace(); return isset(self::$RACE[$r]) ? self::$RACE[$r] : array(); }
	public function getRaceBaseVar($key, $default=false) { $d = self::getRaceBase(); return isset($d[$key]) ? $d[$key] : $default; }
	public function getRaceBonusVar($key, $default=false) { $d = self::getRaceBonus(); return isset($d[$key]) ? $d[$key] : $default; }
	
	/**
	 * @return Lamb_User
	 */
	public function getUser()
	{
		#XXX What the heck?
		$user = $this->getVar('sr4pl_uid');
		if (false !== ($server = Lamb::instance()->getServer($user->getVar('lusr_sid'))))
		{
			if (false !== ($u = $server->getUser($user->getVar('lusr_name'))))
			{
				return $u;
			}
		}
		return $user;
	}
		
	#################
	### Temp vars ###
	#################
	private $sr4_temp_vars = array();
	public function getTemp($key, $default=false) { return isset($this->sr4_temp_vars[$key]) ? $this->sr4_temp_vars[$key] : $default; }
	public function getTempVars() { return $this->sr4_temp_vars; }
	public function hasTemp($key) { return isset($this->sr4_temp_vars[$key]); }
	public function setTemp($key, $value=1) { $this->sr4_temp_vars[$key] = $value; }
	public function unsetTemp($key) { unset($this->sr4_temp_vars[$key]); }
	public function unsetTemps($keys) { foreach ($keys as $key) $this->unsetTemp($key); }
	public function increaseTemp($key, $by) { $this->setTemp($key, $this->getTemp($key,0)+$by); }
	
	##################
	### Const vars ###
	##################
	private $sr4_const_vars = array();
	public function getConst($key) { return $this->sr4_const_vars[$key]; }
	public function getConstVars() { return $this->sr4_const_vars; }
	public function hasConst($key) { return isset($this->sr4_const_vars[$key]); }
	public function setConst($key, $value) { $this->sr4_const_vars[$key] = $value; $this->updateConstVars(); }
	public function unsetConst($key) { unset($this->sr4_const_vars[$key]); $this->updateConstVars(); }
	public function increaseConst($key, $by) { $old = $this->hasConst($key) ? $this->getConst($key) : 0; $this->setConst($key, $old+$by); }
	public function decreaseConst($key, $by) { $old = $this->hasConst($key) ? $this->getConst($key) : 0; $new = $old+$by; if ($new == 0) { $this->unsetConst($key); } else { $this->setConst($key, $new); } }
	
	###############
	### AI vars ###
	###############
	private $sr4_view;
	public function &getAIView()
	{
		return $this->sr4_view;
	}
	public function initAIView()
	{
		$this->sr4_view = new SR_AIView($this, $this);
	}
	
	##############
	### Remote ###
	##############
	private $remote_pid = 0;
	public function setRemotePlayer(SR_Player $player) { $this->remote_pid = $player->getID(); } 
	public function unsetRemotePlayer() { $this->remote_pid = 0; }
	public function getRemotePlayer() { return $this->remote_pid === 0 ? false : Shadowrun4::getPlayerByPID($this->remote_pid); }
	
	#################
	### Validator ###
	#################
	public static function isValidRace($race) { return array_key_exists($race, self::$RACE); }
	public static function isValidGender($gender) { return array_key_exists($gender, self::$GENDER); }
	public static function getRandomRace() { return Shadowfunc::randomListItem(self::getHumanRaces()); }
	public static function getRandomGender() { return Shadowfunc::randomListItem('male', 'female'); }
	public static function getHumanRaces()
	{
		$races = array();
		foreach (SR_Player::$RACE as $race => $data)
		{
			if (!in_array($race, SR_Player::$NPC_RACES))
			{
				$races[] = $race;
			}
		}
		return $races;
	}
	
	##############
	### Static ###
	##############
	/**
	 * Init static player stuff.
	 * @author digitalseraphim
	 */
    public static function init()
    {
    	self::$ALL = array_merge(self::$ATTRIBUTE, self::$SKILL, self::$COMBAT_STATS, self::$MAGIC_STATS, self::$MOUNT_STATS, self::$KNOWLEDGE);
    	self::$REV_ALL = array_flip(self::$ALL);
    }
    
    public static function getAllModifiers()
    {
    	return self::$ALL;
    }
	
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
		return self::reloadPlayer(self::table(__CLASS__)->selectFirstObject('*', "sr4pl_uid={$userid}"));
	}
	
	public static function getByLongName($username)
	{
		if (0 === ($sid = (int)Common::regex('/^.+\\{(\\d+)\\}$/', $username))) {
			return false;
		}
		$username = Shadowfunc::toShortname($username);
		$username = self::escape($username);
		if (false === ($player = self::table(__CLASS__)->selectFirstObject('*', "lusr_sid={$sid} AND lusr_name='{$username}'"))) {
			return false;
		}
		return self::reloadPlayer($player);
	}
	
	public function initRaceGender()
	{
		foreach (SR_Item::mergeModifiers(self::$RACE_BASE[$this->getRace()], array('essence'=>6.0)) as $k => $v)
		{
			$mods['sr4pl_'.$k] = $v;
			unset($mods[$k]);
		}
		return $this->saveVars($mods);
	}
	
	public static function reloadPlayer($player)
	{
		if ($player === false)
		{
			Lamb_Log::logDebug('WARNING: Player is false!');
			return false;
		}
		$player instanceof SR_Player;
		foreach (self::$EQUIPMENT as $e)
		{
			$player->reloadEquipment($e);
		}
		$player->sr4_inventory = $player->reloadItemArray('inventory');
		$player->sr4_cyberware = $player->reloadItemArray('cyberware');
		$player->reloadConstVars();
		$player->reloadEffects();
		$player->modify();
		return $player;
	}
	
	public function reloadConstVars()
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
	
	public static function getPlayerData($userid=0, $serverid=0)
	{
		$back = array(
			'sr4pl_id' => 0,
			'sr4pl_uid' => $userid,
			'sr4pl_sid' => $serverid,
			'sr4pl_partyid' => 0,
			'sr4pl_classname' => NULL,
			'sr4pl_name' => NULL,
			'sr4pl_title' => NULL,
			'sr4pl_race' => 'human',
			'sr4pl_gender' => 'male',
			'sr4pl_age' => NULL,
			'sr4pl_bmi' => NULL,
			'sr4pl_height' => NULL,
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
			'sr4pl_bounty' => 0,
			'sr4pl_bounty_done' => 0,
			'sr4pl_quests_done' => 0,
			'sr4pl_nuyen' => 0,
			'sr4pl_bank_nuyen' => 0,
			'sr4pl_known_words' => ',',
			'sr4pl_known_spells' => ',',
			'sr4pl_known_places' => ',',
			'sr4pl_bank' => NULL,
			'sr4pl_inventory' => NULL,
			'sr4pl_mount_inv' => NULL,
			'sr4pl_cyberware' => NULL,
			'sr4pl_effects' => NULL,
			'sr4pl_const_vars' => NULL,
			'sr4pl_combat_ai' => NULL,
			'sr4pl_game_ai' => NULL,
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
		$data = self::applyStartData(self::getPlayerData($user->getID(), $user->getServerID()));
		$data['sr4pl_name'] = $user->getName();
		$human = new self($data);
		if (false === ($human->insert()))
		{
			return false;
		}
		$human = self::reloadPlayer($human);
		$human->setVar('sr4pl_uid', $user);
		$human->healHP(10000);
		$human->healMP(10000);
		$party = SR_Party::createParty();
		$party->addUser($human);
		$party->pushAction('outside', 'Redmond');
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
		if ($this->isOptionEnabled(self::HELP))
		{
			$this->message($message);
		}
	}
	
	public function hlp($key, $args=NULL)
	{
		if ($this->isOptionEnabled(self::HELP))
		{
			$this->msg('5030', $this->lang($key, $args));
		}
	}
	
	public function message($message)
	{
		if (NULL === ($user = $this->getUser()))
		{
			Lamb_Log::logError('User does not exist: '.$message);
			return false;
		}
		
		if (false !== ($remote = $this->getRemotePlayer()))
		{
			return $remote->message($message);
		}
		
		if ($this->isOptionEnabled(self::WWW_OUT))
		{
			return $this->onMessageWWW($message);
		}
		
		$username = $user->getName();
		if (false === ($server = $user->getServer()))
		{
			Lamb_Log::logError(sprintf('User %s does not have a server: %s', $username, $message));
			return false;
		}
		elseif ($this->isOptionEnabled(self::SILENCE))
		{
			# silence ...
		}
		elseif ($server->getUser($username) === false)
		{
			$this->onMessageTell($message);
		}
		elseif ($this->isOptionEnabled(self::PRIVMSG))
		{
			$server->sendPrivmsg($username, $message);
		}
		else
		{
			$server->sendNotice($username, $message);
		}
		
		return true;
	}
	
	private function onMessageTell($message)
	{
		return SR_Tell::tell($this->getID(), $message);
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
	public function saveBase($field, $value) { return $this->saveVar('sr4pl_'.$field, $value); }
	
	/**
	 * @return SR_Party
	 */
	public function getParty() { return Shadowrun4::getParty($this->getPartyID()); }
	public function getPartyID() { return $this->getInt('sr4pl_partyid'); }
	public function hasParty() { return $this->hasVar('sr4pl_partyid') && ($this->getPartyID() > 0); }
	
	/**
	 * @return SR_Party
	 */
	public function getEnemyParty() { return $this->getParty()->getEnemyParty(); }
	public function isGM() { return Shadowrun4::isGM($this); }
	public function isLeader() { return $this->getParty()->isLeader($this); }
	public function deletePlayer()
	{
		SR_Item::deleteAllItems($this);
		if (false !== ($p = $this->getParty())) {
			$p->kickUser($this, true);
		}
		Shadowrun4::removePlayer($this);
		SR_Quest::deletePlayer($this);
		SR_PlayerVar::deletePlayer($this);
		$this->delete();
	}
	
	public function respawn()
	{
		$party = $this->getParty();
		$city = $party->getCityClass();
		$party->kickUser($this, true);
		$new_party = SR_Party::createParty();
		$new_party->addUser($this, true);
		$location = $city === false ? 'Redmond_Hotel' : $city->getRespawnLocation($this);
//		$location = $city->getRespawnLocation();
		$new_party->pushAction(SR_Party::ACTION_INSIDE, $location);
		$this->updateField('partyid', $new_party->getID());
		$this->msg('5252', array($location));
// 		$this->message(sprintf('You respawn at %s.', $location));
		$this->heal('hp', 20);
		$this->heal('mp', 10);
	}
	
	##############
	### Modify ###
	##############
	/**
	 * Update all stats in memory.
	 */
	public function modify()
	{
//		echo __METHOD__.PHP_EOL;

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
		
		$this->modifyQuests();
		
		$this->modifyEffectsOnce();
		
		$this->modifyMaxima();
		
		$this->modifyEffectsRepeat();
		
		$this->modifyCombat();
		
		$this->modifyOverload(); # malus
		
		$this->modifyFinish();
		
//		$this->modifyParty(); # DEADLOCK!
//		$this->modifyClamp();
	}
	
//	private function modifyClamp()
//	{
//	}

	private function modifyFinish()
	{
		$this->sr4_data_modified['max_hp'] = round($this->sr4_data_modified['max_hp'], 2);
		$this->sr4_data_modified['max_mp'] = round($this->sr4_data_modified['max_mp'], 2);
		
		if ($this->isLocked())
		{
			$this->modifyLevelLocked();
		}
		else
		{
			$this->modifyLevelInventory();
		}
	}
	
	private function modifyLevelLocked()
	{
		$this->modifyLevelItems($this->sr4_equipment);
	}
	
	private function modifyLevelInventory()
	{
		$this->modifyLevelItems(array_merge($this->sr4_equipment, $this->sr4_inventory));
	}
	
	private function modifyLevelItems(array $items)
	{
		$eq = self::$EQUIPMENT;
		unset($eq['mo']);
		
		$max = array();
		
		foreach ($items as $item)
		{
			$item instanceof SR_Item;
			$type = $item->getItemType();
			$lev = $item->getItemLevel();
			if (in_array($type, $eq, true))
			{
				if (!isset($max[$type]))
				{
					$max[$type] = $lev;
				}
				else
				{
					$max[$type] = max(array($max[$type], $lev));
				}
			}
		}
		
		$add = array_sum($max);
		
		$add /= 4;
		
		$add = round($add);
		
		$this->sr4_data_modified['level'] += $add;
	}
	
	private function modifyOverload()
	{
		$load = $this->get('weight') / $this->get('max_weight'); # 1.0 == 100.0%-load == 0.00%-overload
		$load = Common::clamp($load, 0.0, 2.0); # clamp to +100%-overload
		if ($load > 1.0)
		{
			$load -= 1.0; # 100% malus
			$perc = $load * self::MAX_WEIGHT_MALUS;
// 			echo sprintf("Player gets malus of %.02f%%\n", $perc*100);
			$perc = 1 - $perc;
			$this->sr4_data_modified['attack'] = round($this->sr4_data_modified['attack'] * $perc, 1); 
			$this->sr4_data_modified['defense'] = round($this->sr4_data_modified['defense'] * $perc, 1); 
		}
	}
	
	private function modifyQuests()
	{
		$this->sr4_data_modified['reputation'] += $this->getBase('quests_done') * 0.1;
	}

	# DEADLOCK !
//	private function modifyParty()
//	{
//		if ($this->getPartyID() > 0)
//		{
//			$this->sr4_data_modified['luck'] += $this->getParty()->getPartyLevel() * 0.02;
//		}
//	}
		
	private function modifyInventory()
	{
		foreach ($this->sr4_inventory as $item)
		{
			$item instanceof SR_Item;
			$this->sr4_data_modified['weight'] += $item->getItemWeightStacked();
		}
	}
	
	private function initModify()
	{
		$this->sr4_data_modified = array(
			'base_hp' => $this->getVar('sr4pl_base_hp'),
			'base_mp' => $this->getVar('sr4pl_base_mp'),
			'hp_per_body' => self::HP_PER_BODY,
			'mp_per_magic' => self::MP_PER_MAGIC,
			'mp_per_casting' => self::MP_PER_CASTING,
			'level' => $this->getVar('sr4pl_level'),
			'bad_karma' => $this->getVar('sr4pl_bad_karma'),
		);
		$this->initModifyStats(self::$COMBAT_STATS);
		$this->initModifyStats(self::$MAGIC_STATS);
		$this->initModifyStats(self::$MOUNT_STATS);
		$this->initModifyStats(self::$CONDITIONS);
		$this->initModifyArray(self::$SKILL);
		$this->initModifyArray(self::$ATTRIBUTE);
		$this->initModifyArray(self::$KNOWLEDGE);
		$this->initModifyStats(array_keys(SR_Spell::getSpells()), -1);
		foreach (explode(',', $this->getVar('sr4pl_known_spells')) as $data)
		{
			if ($data !== '')
			{
				$d = explode(':', $data);
				$this->sr4_data_modified[$d[0]] = $d[1];
			}
		}
	}
	
	private function initModifyStats(array $keys, $v=0)
	{
		foreach ($keys as $key)
		{
			$this->sr4_data_modified[$key] = $v;
		}
	}
	
	private function modifyMaxima()
	{
		if ($this->isHuman())
		{
			$basehp = self::BASE_HP;
			$this->sr4_data_modified['max_mp'] +=
				 $this->get('magic') * $this->get('mp_per_magic') /*+ $this->get('mp_per_magic')*/ + # -1?
				 $this->get('base_mp') + self::BASE_MP + # Race bonus
				 $this->get('casting') * $this->get('mp_per_casting') /*+ $this->get('mp_per_casting')*/; # -1?
		}
		else
		{
			$basehp = self::BASE_HP_NPC;
			$this->applyModifiers($this->getNPCModifiersB());
		}
		
		$this->sr4_data_modified['max_hp'] += $this->get('body') * $this->get('hp_per_body') + $this->get('base_hp') + $basehp;
		$this->sr4_data_modified['max_weight'] += $this->get('strength') * self::WEIGHT_PER_STRENGTH + self::WEIGHT_BASE;
	}
	
	private function modifyCombat()
	{
		$this->applyModifiers($this->getWeapon()->getItemModifiersW($this));
		$this->sr4_data_modified['defense'] += round(($this->get('quickness')/4), 1);
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
		$race = $this->getRace();
		if (!isset(self::$RACE[$race]))
		{
			$msg = sprintf('%s has an invalid race: "%s".', $this->getName(), $race);
			Lamb_Log::logError($msg);
			GWF_Log::logCritical($msg);
			$race = 'human';
		}
		$this->applyModifiers(self::$RACE[$race]);
	}
	
	private function modifyGender()
	{
		$gender = $this->getGender();
		if (!isset(self::$GENDER[$gender]))
		{
			$msg = sprintf('%s has an invalid gender: "%s".', $this->getName(), $gender);
			Lamb_Log::logError($msg);
			GWF_Log::logCritical($msg);
			$gender = 'male';
		}
		$this->applyModifiers(self::$GENDER[$gender]);
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
	
	private function modifyEffectsOnce()
	{
		$changed = false;
		foreach ($this->sr4_effects as $i => $effect)
		{
			$effect instanceof SR_Effect;
			if (!$effect->isOnce())
			{
				continue;
			}
			
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
	
	private function modifyEffectsRepeat()
	{
		$changed = false;
		foreach ($this->sr4_effects as $i => $effect)
		{
			$effect instanceof SR_Effect;
			if ($effect->getMode() !== SR_Effect::MODE_REPEAT) {
				continue;
			}
			
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
	
	/**
	 * Get the players spells. Returns spell=>level assoc array.
	 * @return array
	 */
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
	
	public function saveSpellData(array $data)
	{
		$s = '';
		foreach ($data as $name => $level)
		{
			$s .= sprintf(',%s:%s', $name, $level);
		}
		return $this->saveVar('sr4pl_known_spells', $s.',');
	}
	
	public function setSpellData(array $data)
	{
		$s = '';
		foreach ($data as $name => $level)
		{
			$s .= sprintf(',%s:%s', $name, $level);
		}
		return $this->setVar('sr4pl_known_spells', $s.',');
	}
	
	public function getSpellBaseLevel($spellname)
	{
		$data = $this->getSpellData();
		return isset($data[$spellname]) ? $data[$spellname] : -1;
	}
	
	public function levelupSpell($spellname, $by=1)
	{
		if (false === SR_Spell::getSpell($spellname))
		{
			return false;
		}
		
		$data = $this->getSpellData();
		if (isset($data[$spellname]))
		{
			$data[$spellname] += $by;
		}
		else
		{
			$data[$spellname] = 0;
		}
		
		return $this->saveSpellData($data);
	}
	
	/**
	 * Get a spell from argument. Enum or spellname. 
	 * @param string $arg
	 * @return SR_Spell|false
	 */
	public function getSpell($arg)
	{
		if (is_numeric($arg))
		{
			return $this->getSpellByEnum(intval($arg, 10));
		}
		else
		{
			return $this->getSpellByName($arg);
		}
	}
	
	public function getSpellByEnum($n)
	{
		if ($n < 1)
		{
			return false;
		}
		$spells = $this->getSpellData();
		if ($n > count($spells))
		{
			return false;
		}
		$back = array_slice(array_keys($spells), $n-1, 1);
		
		$spell = SR_Spell::getSpell($back[0]);
		$spell->setCaster($this);
		return $spell;
	}
	
	public function getSpellByName($sn)
	{
		$sn = strtolower($sn);
		$spells = $this->getSpellData();
		if (false === isset($spells[$sn]))
		{
			return false;
		}
		$spell = SR_Spell::getSpell($sn);
		$spell->setCaster($this);
		return $spell;
	}
	
	#################
	### Equipment ###
	#################
	/**
	 * @return SR_Weapon
	 */
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
		if ( ($with_fists) && (!$this->hasEquipment('weapon')) )
		{
			$back['weapon'] = Item_Fists::staticFists();
		}
		$back = array_merge($back, $this->sr4_equipment);
		ksort($back);
		return $back;
	}
	
	public function equip(SR_Equipment $item)
	{
		unset($this->sr4_inventory[$item->getID()]);
		$this->updateInventory();
		$this->updateEquipment($item->getItemType(), $item);
	}
	
	public function unequip(SR_Equipment $item, $announce=true)
	{
		$field = $item->getItemType();
		$itemid = $item->getID();
		# Can unequip?
		if ( (false === ($item = $this->getEquipment($field))) || ($item->getID() !== $itemid) )
		{
			return false;
		}
		
		$this->sr4_inventory[$itemid] = $item;
		$this->updateInventory();
		$this->updateEquipment($field, NULL);

		$busy = $this->isFighting() ? $this->busy(self::UNEQUIP_TIME) : 0;
		
		if ($announce)
		{
			$this->msg('5203', array($item->getName(), $busy));
// 			$msg = 'You put your '.$item->getItemName().' into the inventory.';
// 			if ($this->isFighting())
// 			{
// 				$msg .= sprintf(' %ss busy.', $busy);	
// 			}
// 			$this->message($msg);
		}
//		$this->modify();
		$this->setOption(SR_Player::EQ_DIRTY|SR_Player::INV_DIRTY|SR_Player::STATS_DIRTY);
		return true;
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
		foreach (func_get_args() as $ef)
		{
			$this->addEffect($ef);
		}
		$this->updateEffects();
		$this->modify();
	}
	
	private function addEffect(SR_Effect $effect)
	{
		if ($effect->getMode() === SR_Effect::MODE_ONCE_EXTEND)
		{
			$this->extendEffect($effect);
		}
		else
		{
			$this->sr4_effects[] = $effect;
		}
	}
	
	private function extendEffect(SR_Effect $effect)
	{
		$kk = $effect->getModifiersRaw();
		$kk = key($kk);
		$seconds = $effect->getETA();
		foreach ($this->sr4_effects as $ef)
		{
			$ef instanceof SR_Effect;
			$mod = $ef->getModifiersRaw();
			foreach ($mod as $k => $v)
			{
				if ($kk === $k)
				{
//					printf("Extending effect %s\n", $seconds);
					$ef->extendTimeEnd($seconds);
					return true;
				}
			}
		}
		$this->sr4_effects[] = $effect;
		return true;
	}
	
	private function updateEffects()
	{
		if (count($this->sr4_effects) === 0)
		{
			return $this->saveVar('sr4pl_effects', NULL);
		}
		else
		{
			return $this->saveVar('sr4pl_effects', serialize($this->sr4_effects));
		}
	}
	
//	public function effectsReset()
//	{
//		$this->sr4_effects = array();
//		$this->updateEffects();
//		$this->modify();
//	}
	
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
			
			elseif ($effect->getMode() === SR_Effect::MODE_REPEAT)
			{
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
		
		return true;
	}
	
	public function refreshMPTimer()
	{
		if ($this->getParty()->isSleeping())
		{
			return true;
		}
		$ma = $this->getBase('magic');
		if ($ma > 0)
		{
			$gain = $this->getMPGain();
// 			echo sprintf("%s gained %s MP\n", $this->getName(), $gain);
			$gain = $this->healMP($gain);
			if ($gain > 0)
			{
				$this->msg('5260', array(round($gain, 2), $this->getMP(), $this->getMaxMP()));
			}
		}
		return true;
	}
	
	public function getMPGain()
	{
		$multi = $this->isFighting() ? 0.20 : 1.00;
		$ma = $this->get('magic') * 5;
		$ma += ($this->get('orcas')+1) * 20;
		return round(self::MP_REFRESH_MULTI*$ma*$multi, 2);
	}
	
	public function refreshHPTimer()
	{
		if ($this->getParty()->isSleeping())
		{
			return true;
		}
		$ele = $this->get('elephants');
		if ($ele > 0)
		{
			$gain = $this->getHPGain();
			$gain = $this->healHP($gain);
// 			echo sprintf("%s gained %s HP\n", $this->getName(), $gain);
// 			return $this->healHP($gain);
			if ($gain > 0)
			{
				$this->msg('5261', array(round($gain, 2), $this->getHP(), $this->getMaxHP()));
			}
		}
		return true;
	}
	
	public function getHPGain()
	{
		$multi = $this->isFighting() ? 0.20 : 1.00;
		return round(self::HP_REFRESH_MULTI*$this->get('elephants')*$multi, 2);
	}
	
	############
	### Item ###
	############
	/**
	 * @param string $itemname
	 * @return SR_Item
	 */
	public function getItem($itemname, $shortcuts=true)
	{
		$itemname = strtolower($itemname);
		
		# ex 1
		if (is_numeric($itemname))
		{
			return $this->getItemByInvID($itemname);
		}
		
		# ex ar
		if (array_key_exists($itemname, self::$EQUIPMENT))
		{
			$itemname = self::$EQUIPMENT[$itemname];
		}
		
		# ex armor
		if (in_array($itemname, self::$EQUIPMENT, true))
		{
			if ($this->hasEquipment($itemname))
			{
				return $this->getEquipment($itemname);
			}
			elseif ($itemname === 'weapon')
			{
				return Item_Fists::staticFists();
			} 
		}
		
		return $this->getItemByName($itemname, $shortcuts);
	}
	
	public function getBankItemByID($id)
	{
		return $this->getItemByID($this->getBankSorted(), $id, $this->getBankItems());
	}
	
	public function getMountInvItemByID($id)
	{
		return $this->getItemByID($this->getMountInvSorted(), $id, $this->getMountInvItems());
	}
	
	public function getItemByInvID($invid)
	{
		return $this->getItemByID($this->getInventorySorted(), $invid, $this->sr4_inventory);
	}
	
	public function getItemByID(array $items, $id, array $items2)
	{
		$id = (int)$id;
		if ($id > count($items) || $id < 1)
		{
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
	public function getItemByName($itemname, $shortcuts=true)
	{
		return $this->getItemByNameB($itemname, $this->getAllItems(), $shortcuts);
	}
	
	public function getBankItemByName($itemname)
	{
		return $this->getItemByNameB($itemname, $this->getBankItems(), false);
	}
	
	public function getMountInvItemByName($itemname)
	{
		return $this->getItemByNameB($itemname, $this->getMountInvItems(), false);
	}
	
	/**
	 * @param string $itemname
	 * @return SR_Item
	 */
	public function getInvItem($arg)
	{
		if (is_numeric($arg)) {
			return $this->getItemByID($this->getInventorySorted(), $arg, $this->sr4_inventory);
		} else {
			return $this->getInvItemByName($arg);
		}
	}
	
	/**
	 * Get multiple items(equipment) with the same itemname.
	 * @param string $arg
	 * @param int $max
	 * @return array(SR_Item)
	 */
	public function getInvItems($arg, $max=-1)
	{
		$max = $max < 0 ? PHP_INT_MAX : intval($max);

		$back = array();
		
		# Convert id to itemname
		if (is_numeric($arg))
		{
			if (false === ($item = $this->getInvItem($arg)))
			{
				return $back;
			}
			$arg = $item->getItemName();
		}
		
		# Collect by itemname
		foreach (array_reverse($this->sr4_inventory) as $item)
		{
			$item instanceof SR_Item;
			if (!strcasecmp($item->getItemName(), $arg))
			{
				$back[] = $item;
				if (count($back) >= $max)
				{
					break;
				}
			}
		}
		
		return $back;
	}
	
	
	/**
	 * @param string $itemname
	 * @return SR_Item
	 */
	public function getInvItemByName($itemname, $shortcuts=true)
	{
		return $this->getItemByNameB($itemname, $this->sr4_inventory, $shortcuts);
	}
	
	public function getItemByNameB($itemname, array $items, $shortcuts=true)
	{
		$itemname = strtolower($itemname);
		
		foreach (array_reverse($items) as $item)
		{
			if (strtolower($item->getItemName()) === $itemname)
			{
				return $item;
			}
		}
		
		if (strlen($itemname) < 3)
		{
			$shortcuts = false;
		}
		
		return $shortcuts === true
			? $this->getItemByShortNameB($itemname, $items)
			: false;
	}
	
	public function getInvItemByShortName($itemname)
	{
		return $this->getItemByShortNameB($itemname, $this->sr4_inventory);
	}
	
	public function getItemByShortNameB($itemname, array $items)
	{
		$itemname = strtolower($itemname);
		
		$items = array_reverse($items);
		
		# Beginning is better than in the middle
		foreach ($items as $item)
		{
			if (strpos(strtolower($item->getItemName()), $itemname) === 0)
			{
				return $item;
			}
		}
		
		# In the middle still works.
		foreach ($items as $item)
		{
			if (strpos(strtolower($item->getItemName()), $itemname) !== false)
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
		return $this->getItemByNameB($itemname, $this->sr4_cyberware);
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
	### Cyberdeck ###
	#################
	public function hasCyberdeck() { return $this->getCyberdeck() !== false; }
	public function hasHeadcomputer() { return $this->hasCyberware('Headcomputer'); }
	public function getCyberdeck()
	{
		$deck = false;
		$level = -1;
		foreach ($this->sr4_inventory as $item)
		{
			if ($item instanceof SR_Cyberdeck)
			{
				$lvl = $item->getCyberdeckLevel();
				if ($lvl > $level)
				{
					$level = $lvl;
					$deck = $item;
				}
			}
		}
		return $deck;
	}
	
	#################
	### Inventory ###
	#################
	public function getInventory()
	{
		return $this->sr4_inventory;
	}
	
	public function getInventorySorted()
	{
		return $this->getItemsSorted($this->sr4_inventory);
	}
	
	public function getBankSorted()
	{
		return $this->getItemsSorted($this->getBankItems());
	}
	
	public function getMountInvSorted()
	{
		return $this->getItemsSorted($this->getMountInvItems());
	}
	
	private function getItemsSorted(array $items)
	{
		$temp = array();
		foreach ($items as $itemid => $item)
		{
			$name = $item->getItemName();
			if (isset($temp[$name]))
			{
				$temp[$name][0] += $item->getAmount();
				$temp[$name][1] = $itemid;
			}
			else
			{
				$temp[$name] = array($item->getAmount(), $itemid);
			}
		}
		return $temp;
	}

	/**
	 * Swap the position of 2 items.
	 * @author digitalseraphim
	 * @param string $item1
	 * @param string $item2
	 * @return int
	 */
	public function swapInvItems($item1, $item2)
	{
		$items1 = $this->getInvItems($item1);
		$items2 = $this->getInvItems($item2);
		
		if(count($items1) == 0){
			return -1;
		}
		if(count($items2) == 0){
			return -2;
		}
		if($items1[0]->getName() == $items2[0]->getName()){
			return -3;
		}
		
		$beforeFirst = array();
		$firstKey = -1;
		$firstVal = null;
		$beforeSecond = array();
		$secondKey = -1;
		$toMove = array();
		$newinv = array();
		$currentAdd =& $beforeFirst;

		foreach($this->sr4_inventory as $key=>$value){
			$vName = $value->getName();
			if($vName == $items1[0]->getName() || $vName == $items2[0]->getName()){
				if($firstKey == -1){
					$firstKey = $key;
					$firstVal = $value;
					$currentAdd =& $beforeSecond;
				}elseif($secondKey == -1 && $vName != $firstVal->getName()){
					$secondKey = $key;

					foreach($beforeFirst as $k => $v){
						$newinv[$k] = $v;
					}
					$newinv[$key] = $value;
					foreach($beforeSecond as $k => $v){
						$newinv[$k] = $v;
					}
					$newinv[$firstKey] = $firstVal;
					foreach($beforeSecond as $k => $v){
						$newinv[$k] = $v;
					}
					foreach($toMove as $k => $v){
						$newinv[$k] = $v;
					}
					$currentAdd =& $newinv;
					$toMove =& $newinv;
				}else{
					$toMove[$key] = $value;
				}
			}else{
				$currentAdd[$key] = $value;
			}
		}

		$this->sr4_inventory = $newinv;
		$this->updateInventory();
	}
	
	/**
	 * Give items to a player. If 0 items are given, nothing is done and true is returned.
	 * If the from argument is empty, no message is sent.
	 * @param array $items
	 * @param string $from
	 * @return true|false
	 */
	public function giveItems(array $items, $from='')
	{
		if (0 === ($cnt = count($items)))
		{
			return true;
		}
		
		$format = $this->lang('fmt_giveitems');
		
		$b = chr(2);
		$message = '';
		foreach ($items as $item)
		{
			$this->giveItem($item);
			$amt = $item->getAmount();
			$multi = $amt > 1 ? "{$amt} x " : '';
			$message .= sprintf($format, $amt, $item->getItemName());
// 			$message .= sprintf(", {$b}%s%s{$b}", $multi, $item->getItemName());
		}
		
		if (false === $this->updateInventory())
		{
			return false;
		}
		
		if ($from !== '')
		{
			$message = substr($message, 2);
			$this->getParty()->ntice('5116', array($this->getName(), $message, $from));
// 			$from = " from {$from}";
// 			$plur = $cnt > 1 ? $cnt.' items' : 'an item';
// 			$message = sprintf(' received %s%s: %s.', $plur, $from, $message);
// 			$this->getParty()->message($this, $message);
		}
		
		return true;
	}
	
	public function giveItem(SR_Item $item)
	{
		if ($item->isItemStackable())
		{
			if (false !== ($other = $this->getItem($item->getItemName(), false)))
			{
				$other->increase('sr4it_amount', $item->getAmount());
				$item->delete();
				return true;
			}
		}
		
		$this->sr4_inventory[$item->getID()] = $item;
		
		return $item->saveVar('sr4it_uid', $this->getID());
	}
	
	public function updateInventory()
	{
		if (false === $this->updateItemArray('sr4pl_inventory', $this->sr4_inventory)) {
			return false;
		}
		$this->setOption(self::INV_DIRTY, true);
		$this->modify();
		return true;
	}
	
	private function updateMountInv($mount_inv)
	{
		if (false === $this->updateItemArray('sr4pl_mount_inv', $mount_inv)) {
			return false;
		}
		$this->setOption(self::MOUNT_DIRTY, true);
		return true;
	}
	
	private function updateItemArray($field, array $items)
	{
		return $this->saveVar($field, implode(',', array_keys($items)));
	}
	
	public function removeFromInventory(SR_Item $item)
	{
		$id = $item->getID();
		if (isset($this->sr4_inventory[$id]))
		{
			unset($this->sr4_inventory[$id]);
			return $this->updateInventory();
		}
		return true;
	}
	
	public function removeItem(SR_Item $item)
	{
		if ($item->isEquipped($this))
		{
			$this->unequip($item, false);
		}
		return $this->removeFromInventory($item);
	}
	
	#############
	### Mount ###
	#############
	/**
	 * Get the players mount.
	 * @return SR_Mount
	 */
	public function getMount()
	{
		return $this->hasEquipment('mount') ? $this->getEquipment('mount') : $this->getPockets();
	}
	
	public function getPockets()
	{
		$pockets = SR_Item::getItem('Pockets');
		$pockets->setOwnerID($this->getID());
		return $pockets;
	}
	
	public function putInMountInv(SR_Item $item)
	{
		if ($item->isItemStackable())
		{
			if (false !== ($other = $this->getMountInvItemByName($item->getItemName())))
			{
				$other->increase('sr4it_amount', $item->getAmount());
				$item->delete();
				return true;
			}
		}
		$mount_inv = $this->getMountInvItems();
		$mount_inv[$item->getID()] = $item;
		return $this->updateMountInv($mount_inv);
	}
	
	public function getMountInvItemCount()
	{
		return count($this->getMountInvItems());
	}
	
	public function getMountInvItems()
	{
		$mount_inv = array();
		foreach (explode(',', $this->getVar('sr4pl_mount_inv')) as $itemid)
		{
			$itemid = (int) $itemid;
			if (false !== ($item = SR_Item::getByID($itemid)))
			{
				$mount_inv[$itemid] = $item;
			}
		}
		return $mount_inv;
	}

	public function getMountInvItemsByItemName($itemname)
	{
		$back = array();
		foreach ($this->getMountInvItems() as $itemid => $item)
		{
			if ($item->getItemName() === $itemname)
			{
				$back[] = $item;
			}
		}
		return $back;
	}
	
	public function removeFromMountInv(SR_Item $item)
	{
		$mount_inv = $this->getMountInvItems();
		unset($mount_inv[$item->getID()]);
		return $this->updateMountInv($mount_inv);
	}
	
	/**
	 * Get a mount_inv item by mount_inv_id or itemname.
	 * @param string|int $arg
	 * @return SR_Item
	 */
	public function getMountInvItem($arg)
	{
		return is_numeric($arg) ? $this->getMountInvItemByID($arg) : $this->getMountInvItemByName($arg);
	}
	
	############
	### Bank ###
	############
	public function putInBank(SR_Item $item)
	{
		if ($item->isItemStackable())
		{
			if (false !== ($other = $this->getBankItemByName($item->getItemName())))
			{
				$other->increase('sr4it_amount', $item->getAmount());
				$item->delete();
				return true;
			}
		}
		
		$bank = $this->getBankItems();
		$bank[$item->getID()] = $item;
		return $this->updateBank($bank);
	}
	
	private function updateBank(array $items)
	{
		return $this->updateItemArray('sr4pl_bank', $items);
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
	
	public function getBankItemsByItemName($itemname)
	{
		$back = array();
		foreach ($this->getBankItems() as $itemid => $item)
		{
			if ($item->getItemName() === $itemname)
			{
				$back[] = $item;
			}
		}
		return $back;
	}
	
	
	public function removeFromBank(SR_Item $item)
	{
		$bank = $this->getBankItems();
		unset($bank[$item->getID()]);
		return $this->updateBank($bank);
	}
	
	/**
	 * Get a bank item by bank_id or itemname.
	 * @param string|int $arg
	 * @return SR_Item
	 */
	public function getBankItem($arg)
	{
		return is_numeric($arg) ? $this->getBankItemByID($arg) : $this->getBankItemByName($arg);
	}
	
	#############
	### Nuyen ###
	#############
	public function hasNuyen($ny)
	{
		return $ny < 0 ? false : $this->getBase('nuyen') >= $ny;
	}
	
	public function pay($nuyen)
	{
		if ($nuyen <= 0)
		{
			return true;
		}
		return $this->hasNuyen($nuyen) ? $this->giveNuyen(-$nuyen) : false;
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
	
	public function getKnowledgeByArg($field, $arg)
	{
		if (is_numeric($arg))
		{
			if (false === ($arg = $this->getKnowledgeByID($field, $arg)))
			{
				return false;
			}
		}
		elseif (!$this->hasKnowledge($field, $arg))
		{
			return false;
		}
		return $arg;
	}
	
	public function hasKnowledge($field, $knowledge)
	{
		return stripos($this->getKnowledge($field), ",$knowledge,") !== false;
	}
	
	public function giveKnowledge($field, $knowledge, $announce=true)
	{
		static $txt = array('places'=>'location', 'words'=>'word');
		$b = chr(2);
		$args = func_get_args();
		$field = array_shift($args);
		
		if (!isset($txt[$field]))
		{
			Lamb_Log::logError("WARNING: Unknown knowledge type: {$field}");
			return false;
		}
		
		foreach ($args as $knowledge)
		{
			if ($this->hasKnowledge($field, $knowledge))
			{
				continue;
			}
			$k = $this->getKnowledge($field);
			if (false === $this->saveVar('sr4pl_known_'.$field, $k.$knowledge.','))
			{
				return false;
			}
			
			if ($field === 'places')
			{
				$this->setOption(self::LOCATION_DIRTY, true);
			}
			elseif ($field === 'words')
			{
				$this->setOption(self::WORDS_DIRTY, true);
			}
			
			if ($announce)
			{
				$this->msg('5250', array($this->lang('ks_'.$field), $knowledge, $field));
// 				$this->message(sprintf('You know a new %s: %s.', $txt[$field], $b.$knowledge.$b));
			}
		}
		return true;
	}
	
	public function removeKnowledge($field, $knowledge)
	{
		$knowledge = strtolower($knowledge);
		if (!$this->hasKnowledge($field, $knowledge))
		{
			return $player->msg('1023');
// 			$this->message(sprintf('You don\'t have knowledge for %s.', $knowledge));
// 			return true;
		}
		$k = $this->getKnowledge($field);
		if (false === $this->saveVar('sr4pl_known_'.$field, str_ireplace(",$knowledge,", ',', $k)))
		{
			return false;
		}
		
		return $this->msg('5046', array($this->lang('ks_'.$field), $knowledge));
// 		$this->message(sprintf('You surely forgot about the %s: %s.', $field, $knowledge));
// 		return true;
	}
	
	############
	### Heal ###
	############
	/**
	 * Heal a players HP. Return the new current HP
	 * @see healMP()
	 * @param float $gain
	 * @return float
	 */
	public function healHP($gain)
	{
		return $this->heal('hp', $gain);
	}

	/**
	 * Heal a players MP. Return the new current MP
	 * @see healHP()
	 * @param float $gain
	 * @return float
	 */
	public function healMP($gain)
	{
		return $this->heal('mp', $gain);
	}

	private function heal($field, $gain)
	{
		$old = $this->getBase($field);
		$max = $this->get('max_'.$field);
		$new = round(Common::clamp($old+$gain, 0.0, $max), 2);
		$this->setOption(SR_Player::STATS_DIRTY, true);
		$this->updateField($field, $new);
		return $new-$old;
	}
	
	/**
	 * Deal damage to a target.
	 * @see healHP()
	 * @param float $damage
	 */
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
		$b = chr(2);
		
		if ($xp <= 0)
		{
			return false;
		}
		
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
			$this->getParty()->notice(sprintf("{$b}%s{$b} reached {$b}level %s(+%d){$b}.", $this->getName(), $this->getBase('level'), $level));
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
			$this->msg('5251', array($this->getBase('karma'), $karma));
// 			$this->message(sprintf("You now have {$b}%d(+%d) karma{$b}. With karma you can #lvlup.", $this->getBase('karma'), $karma));
		}
		
		if ( ($karma > 0) || ($level > 0) )
		{
			$this->modify();
		}
	}
	
	public function giveNuyen($nuyen)
	{
		return $this->alterField('nuyen', round($nuyen, 2));
	}
	
	public function giveBankNuyen($nuyen)
	{
		return $this->alterField('bank_nuyen', round($nuyen, 2));
	}
	
	public function resetXP()
	{
		$xp = $this->getBase('xp');
		$this->alterField('xp', -$xp);
		$this->alterField('xp_level', -$xp);
		$this->alterField('xp_total', -$xp);
		$this->msg('5253', array(round($xp, 2)));
// 		$this->message(sprintf('You lost %.02f XP!', $xp));
	}
	
	##############
	### Update ###
	##############
	public function updateField($field, $value)
	{
		if (false === ($this->saveVar('sr4pl_'.$field, $value))) {
			return false;
		}
//		$this->modify();
		return true;
	}
	
	public function increaseField($field, $by=1)
	{
		return $this->increase('sr4pl_'.$field, $by);
	}
	
	##############
	### Combat ###
	##############
	
	private $combat_eta = 0;
	private $combat_stack = '';
	private $old_combat_stack = '';
	private $combat_target = 0;
	
	public function calcBusyTime($seconds)
	{
		$q = $this->get('quickness');
		$seconds -= $q / 2;
		$seconds += rand(1, 10) - 5;
		
		$f = $this->get('frozen') * 10;
//		printf(" ---- Freeze busy: %s\n", $f);
		$seconds += $f;
		return round(Common::clamp($seconds, 4));
	}
	
	public function busy($seconds)
	{
		$seconds = $this->calcBusyTime($seconds);
		$this->setCombatETA($seconds);
		return $seconds;
	}
	
	public function setCombatETA($seconds)
	{
		$this->combat_eta = Shadowrun4::getTime() + $seconds;
	}
	
	public function isBusy()
	{
		return $this->combat_eta > Shadowrun4::getTime();
	}
	
	protected function cmdAttackRandom()
	{
		if (false === ($ep = $this->getEnemyParty()))
		{
			return '# 1';
		}
		$targets = $ep->getMembers();
// 		if (count($targets) === 0)
// 		{
// 			return '# 1';
// 		}
		
		$target = $targets[array_rand($targets)];
		return '# '.$target->getEnum();
	}

	/**
	 * Let L be the last locking command and N the last non-locking
	 * command after L. If no such command exists we use '' instead. We
	 * write old_combat_stack,combat_stack to denote the stack.
	 *
	 * If N === '', stack should be '',L.
	 * If N !== '', stack should be L,N.
	 **/
	public function combatPush($message)
	{
//		echo 'Pushing "'.$message.'" on '.$this->getName().'\'s combat stack.'.PHP_EOL;

		# If new command is locking -> '',message
		if (true === $this->isLockingCommand($message))
		{
			$this->old_combat_stack = '';
		}
		# New command is not locking; push previous locking command
		# -> combat_stack,message
		else if (true === $this->isLockingCommand($this->combat_stack))
		{
			$this->old_combat_stack = $this->combat_stack;
		}

		$this->combat_stack = $message;
	}
		
	public function combatTimer()
	{
		if ($this->isBusy())
		{
			return false; # Nothing changed.
		}
		
		# Save original party in case of flee.
		$p = $this->getParty();
		
		# No command on stack; make one up! -> '',rand()
		if ($this->combat_stack === '')
		{
			$this->combat_stack = $this->cmdAttackRandom();
		}
		
		# Clear combat_stack to avoid repeat via onFightDone/ExecAnyway
		$action = $this->combat_stack;
		$this->combat_stack = '';

		# Execute top of stack.
		$result = Shadowcmd::onExecute($this, $action);

		# Restore combat_stack
		$this->combat_stack = $action;

		# If not a keeper (failed or not locking), we pop the stack.
		# -> '',old
		if (false === $this->keepCombatStack($result, $action))
		{
			$this->combat_stack = $this->old_combat_stack;
			$this->old_combat_stack = '';
		}
		
		return !$p->isFighting(); # Did this player kill the last enemy?
	}
	
	private function isLockingCommand($command)
	{
		$c = strtolower($command);
		if (Common::startsWith($c, '#'))
		{
			return true;
		}
		if (Common::startsWith($c, 'attack'))
		{
			return true;
		}
		if (Common::startsWith($c, 'idle'))
		{
			return true;
		}
		if (Common::startsWith($c, 'fl'))
		{
			return true;
		}
// 		if (Common::startsWith($c, 'flee'))
// 		{
// 			return true;
// 		}
		return false;
	}
	
	private function keepCombatStack($bool, $stack)
	{
		if ($bool === false)
		{
			return false;
		}
		return $this->isLockingCommand($stack);
	}
	
	public function getLootXP()
	{
		return round($this->getBase('strength')/2 + $this->getBase('quickness')/4 + 0.5, 1);
	}
	
	public function getLootNuyen()
	{
		$back = round($this->getBase('nuyen') / 8, 2);
		$this->msg('', array(Shadowfunc::displayNuyen($back)));
// 		$this->message(sprintf('You lost %s!', Shadowfunc::displayNuyen($back)));
		return $back;
	}
	
	public function gotKilledBy(SR_Player $killer)
	{
		SR_PlayerStats::onKill($killer, $this);
		
		if ($this->isHuman())
		{
			$this->announceKilled($killer);
		}
		
// 		$killer = $killer->getParty()->getKiller($killer);
		
		if ($killer->isHuman())
		{
			$this->gotKilledByHuman($killer);
		}
		else
		{
			$this->gotKilledByNPC($killer);
		}
		
		$this->respawn();
	}
	
	public function gotKilledByNPC(SR_Player $killer)
	{
		if ($this->isRunner())
		{
			# Forever a dead?
			if ( ($killer->isNPC()) || ($killer->isRunner()) )
			{
				$this->saveOption(self::DEAD, true);
			}
		}
// 		$this->announceKilled($killer);
	}
	
	private function looseItem(SR_Player $killer)
	{
		Lamb_Log::logDebug(sprintf('%s could loose an item!', $this->getName()));
		$items = array_merge($this->sr4_equipment, $this->sr4_inventory);
		foreach ($items as $i => $item)
		{
			$item instanceof SR_Item;
			if ( ($item instanceof SR_Mount) || (!$item->isItemDropable()) )
			{
				unset($items[$i]);
			}
		}
		if (0 !== ($rand = rand(0, count($items))))
		{
			shuffle($items);
			$item = array_pop($items);
			$item instanceof SR_Item;
			if ($item->isEquipped($this))
			{
				$this->unequip($item, false);
			}
			$this->removeFromInventory($item);
			$killer->giveItems(array($item), 'killing '.$this->getName());
			$this->msg('5255', array($item->getAmount(), $item->getItemName()));
// 			$this->message(sprintf('You lost your %s.', $item->getItemName()));
		}
	}
	
	public function gotKilledByHuman(SR_Player $killer)
	{
		SR_Bounty::onKilledByHuman($killer, $this);
		
		if (false === SR_KillProtect::isKillProtected($killer, $this))
		{
			SR_KillProtect::onKilled($killer, $this);
		}
		
		if (false === SR_KillProtect::isKillProtectedLevel($killer, $this))
		{
			$this->looseItem($killer);
		}
// 		return $this->gotKilledByNPC($killer);
	}
	
	private function announceKilled(SR_Player $killer)
	{
		$famous = $this->isRunner() ? 'famous' : 'newbie';
		$famous2 = $killer->isRunner() ? 'famous' : 'newbie';
		$npchuman = $killer->isHuman() ? 'runner' : 'NPC';
		$message = sprintf('[Shadowlamb] - The %s runner %s got killed by the %s %s %s', $famous, $this->getName(), $famous2, $npchuman, $killer->getName());
		Shadowshout::sendGlobalMessage($message);
	}
	
	public function itemDurationTimer()
	{
		foreach ($this->getAllItems() as $item)
		{
			$item instanceof SR_Item;
			if ($item->isBreaking())
			{
				$item->breakItem();
			}
		}
	}
	
	public function getCritPermille()
	{
		return Common::clamp(28 + $this->get('sharpshooter') * 7);		
	}
	
	public function iExecAnyway()
	{
		$anyway = array(
			'eq','equip',
			'g','give',
			'uq','unequip',
			'ca','cast',
			'u','use'
		);
		$cmd = $this->combat_stack;
		$cmd = Common::substrUntil($cmd, ' ', $cmd);
		if (in_array($cmd, $anyway, true))
		{
			return Shadowcmd::onExecute($this, $this->combat_stack);
		}
		$this->combat_stack = '';
		$this->old_combat_stack = '';
		return true;
	}
	
}
?>
