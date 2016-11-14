<?php
final class TGC_Player extends GDO
{
	private $connectionInterface = null;
	private $jsonUser = null;
	private $secret = null;
	private $lat = null;
	private $lng = null;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'tgc_players'; }
	public function getColumnDefines()
	{
		return array(
			'p_uid' => array(GDO::PRIMARY_KEY|GDO::UINT),
				
			'p_last_slap' => array(GDO::DATE, GDO::NULL, 14),
				
			'p_active_color' => array(GDO::ENUM, TGC_Const::NONE, TGC_Const::$COLORS),
			'p_active_element' => array(GDO::ENUM, TGC_Const::NONE, TGC_Const::$ELEMENTS),
			'p_active_skill' => array(GDO::ENUM, TGC_Const::NONE, TGC_Const::$SKILLS),
			'p_active_mode' => array(GDO::ENUM, TGC_Const::NONE, TGC_Const::$MODES),

			'p_last_color_change' => array(GDO::DATE, GDO::NULL, 14),
			'p_last_element_change' => array(GDO::DATE, GDO::NULL, 14),
			'p_last_skill_change' => array(GDO::DATE, GDO::NULL, 14),
			'p_last_mode_change' => array(GDO::DATE, GDO::NULL, 14),

			'p_fighter_xp' => array(GDO::UINT, 0),
			'p_ninja_xp' => array(GDO::UINT, 0),
			'p_priest_xp' => array(GDO::UINT, 0),
			'p_wizard_xp' => array(GDO::UINT, 0),

			'p_fighter_level' => array(GDO::UINT, 0),
			'p_ninja_level' => array(GDO::UINT, 0),
			'p_priest_level' => array(GDO::UINT, 0),
			'p_wizard_level' => array(GDO::UINT, 0),
				
			'user' => array(GDO::JOIN, GDO::NOT_NULL, array('GWF_User', 'p_uid', 'user_id')),
		);
	}
	
	public function fullPlayerDTO(GWF_User $user)
	{
		return array_merge($this->playerDTO(), $this->ownPlayerDTO(), array('name' => $user->getVar('user_name'), 'gender' => $user->getVar('user_gender')));
	}
	
	public function playerDTO()
	{
		return array(
			'c' => $this->getVar('p_active_color'),
			'e' => $this->getVar('p_active_element'),
			's' => $this->getVar('p_active_skill'),
			'm' => $this->getVar('p_active_mode'),
			'fl' => (int)$this->getVar('p_fighter_level'),
			'nl' => (int)$this->getVar('p_ninja_level'),
			'pl' => (int)$this->getVar('p_priest_level'),
			'wl' => (int)$this->getVar('p_wizard_level'),
		);
	}
	
	public function ownPlayerDTO()
	{
		return array(
			'p_uid' => $this->getVar('p_uid'),
			'cc' => $this->getVar('p_last_color_change'),
			'ec' => $this->getVar('p_last_element_change'),
			'sc' => $this->getVar('p_last_skill_change'),
			'mc' => $this->getVar('p_last_mode_change'),
			'fx' => (int)$this->getVar('p_fighter_xp'),
			'nx' => (int)$this->getVar('p_ninja_xp'),
			'px' => (int)$this->getVar('p_priest_level'),
			'wx' => (int)$this->getVar('p_wizard_xp'),
		);
	}
	
	private static function createPlayer(GWF_User $user)
	{
		$player = new self(array(
			'p_uid' => $user->getID(),
			'p_active_color' => TGC_Const::NONE,
			'p_active_element' => TGC_Const::NONE,
			'p_active_skill' => TGC_Const::NONE,
			'p_active_mode' => TGC_Const::NONE,
			'p_last_color_change' => null,
			'p_last_element_change' => null,
			'p_last_skill_change' => null,
			'p_last_mode_change' => null,
			'p_fighter_xp' => '0',
			'p_ninja_xp' => '0',
			'p_priest_xp' => '0',
			'p_wizard_xp' => '0',
			'p_fighter_level' => '0',
			'p_ninja_level' => '0',
			'p_priest_level' => '0',
			'p_wizard_level' => '0',
		));
		$player->insert();
		$player->setVar('user_name', $user->getVar('user_name'));
		return $player;
	}
	
	public static function getJSONUser()
	{
		if (0 == ($uid = GWF_Session::getUserID())) {
			return false;
		}
		return self::table('GWF_User')->selectFirst("user_id, user_regdate, user_gender, user_lastlogin, user_lastactivity, user_birthdate, user_countryid, user_langid, user_langid2", "user_id=$uid");
	}
	
	private function getSecret()
	{
		$uid = $this->getVar('p_uid');
		return substr(self::table('GWF_User')->selectVar('user_password', "user_id=$uid", '', array('user')), TGC_Const::SECRET_CUT);
	}
	
	public static function getCurrent($create=false)
	{
		$uid = GWF_Session::getUserID();
		if ($uid == 0) {
			return false;
		}
		if ($player = self::table(__CLASS__)->selectFirstObject('*, user_name, user_gender', "p_uid=$uid", '', '', array('user'))) {
			return $player;
		}
		if ($create) {
			return self::createPlayer(GWF_Session::getUser());
		}
		return false;
	}
	
	###############
	### Getters ###
	###############
	public function getName() { return $this->getVar('user_name'); }
	public function getGender() { return $this->getVar('user_gender'); }
	public function lat() { return $this->lat; }
	public function lng() { return $this->lng; }
	
	public function level($skill) { return (int) $this->getVar('p_'.$skill.'_level'); }
	public function sumLevel() { return $this->fighterLevel() + $this->ninjaLevel() + $this->priestLevel() + $this->wizardLevel(); }
	public function fighterLevel() { return $this->level('fighter'); }
	public function ninjaLevel() { return $this->level('ninja'); }
	public function priestLevel() { return $this->level('priest'); }
	public function wizardLevel() { return $this->level('wizard'); }
	
	public function xp($skill) { return (int) $this->getVar('p_'.$skill.'_xp'); }
	public function fighterXP() { return $this->xp('fighter'); }
	public function ninjaXP() { return $this->xp('ninja'); }
	public function priestXP() { return $this->xp('priest'); }
	public function wizardXP() { return $this->xp('wizard'); }

	##################
	### Connection ###
	##################
	public function sendError($i18nKey)
	{
		GWF_Log::logCron(sprintf("%s: %s", $this->getName(), $i18nKey));
		return $this->sendCommand('ERR', $i18nKey);
	}
	
	public function sendJSONCommand($command, $object)
	{
		return $this->sendCommand($command, json_encode($object));
	}
	
	public function sendCommand($command, $payload)
	{
		return $this->send("$command:$payload");
	}
	
	public function send($messageText)
	{
		if ($this->isConnected()) {
			GWF_Log::logCron(sprintf('%s << %s', $this->getName(), $messageText));
			$this->connectionInterface->send($messageText);
		}
	}

	public function disconnect($reason="NO_REASON")
	{
		if ($this->isConnected()) {
			$this->send("CLOSE:".$reason);
			$this->connectionInterface = null;
			$this->connectionInterface = null;
			$this->jsonUser = null;
			$this->secret = null;
			$this->lat = null;
			$this->lng = null;
		}
	}
	
	public function isConnected()
	{
		return $this->connectionInterface !== null;
	}
	
	public function hasPosition()
	{
		return $this->lat !== null;
	}
	
	public function setPosition($lat, $lng)
	{
		if ($lat && $lng) {
			$this->lat = $lat;
			$this->lng = $lng;
		}
	}
	
	public function setConnectionInterface($conn)
	{
		if ($this->isConnected()) {
			$this->disconnect();
		}
		$this->connectionInterface = $conn;
		$this->rehash();
	}
	
	public function getInterfaceConnection()
	{
		return $this->connectionInterface;
	}
	
	###################
	### For Near me ###
	###################
	public function isNearMe(TGC_Player $player)
	{
		if ( ($player == $this) || (!$this->hasPosition()) || (!$player->hasPosition()) ) {
			return false;
		}
		return TGC_Logic::arePlayersNearEachOther($this, $player);
	}
	
	public function forNearMe($callback, $payload)
	{
		foreach (TGC_Global::$PLAYERS as $name=> $player) {
			if ($this->isNearMe($player)) {
				call_user_func($callback, $player, $payload);
			}
		}
	}
	
	###########
	### API ###
	###########
	public function moveTo($newLat, $newLng)
	{
		$this->setPosition($newLat, $newLng);
	}
	
	public function getStatsHash()
	{
		$g = substr($this->getVar('user_gender'), 0, 1);
		$sum = $this->getVar('p_fighter_level') + $this->getVar('p_ninja_level') + $this->getVar('p_priest_level') + $this->getVar('p_wizard_level');
		return sprintf('%s%d', $g, $sum);
	}
	
	
	##############
	### Rehash ###
	##############
	public function rehash()
	{
		$this->rehashLevels();
		$this->rehashJSONUser();
		$this->rehashSecret();
	}
	
	private function rehashLevels()
	{
		$this->rehashSkill('fighter');
		$this->rehashSkill('ninja');
		$this->rehashSkill('priest');
		$this->rehashSkill('wizard');
	}
	
	private function rehashSkill($skill)
	{
		$xp = $this->getVar(sprintf('p_%s_xp', $skill));
		$levelvar = sprintf('p_%s_level', $skill);
		$oldLevel = (int) $this->getVar($levelvar);
		$newLevel = TGC_Logic::levelForXP($xp);
		if ($oldLevel !== $newLevel) {
			return $this->saveVar($levelvar, $newLevel.'');
		}
		return false;
	}
	
	private function rehashJSONUser()
	{
		if ($this->jsonUser === null) {
			$this->jsonUser = $this->getJSONUser();
		}
	}
	
	private function rehashSecret()
	{
		if ($this->secret === null) {
			$this->secret = $this->getSecret();
		}
	}
	
	private function onLevelChanged($skill, $mid)
	{
		$newLevel = $this->getVar('p_'.$skill.'_level');
		
		$payload = array(
			'name' => $this->getName(),
			'level' => $newLevel,
			'skill' => $skill,
		);
		
		$payload = TGC_Commands::payload(json_encode($payload), $mid);
		
		self::forNearMe(function($player, $payload) {
			$player->sendCommand('LVLUP', $payload);
		}, $payload);
	}
	
	public function giveXP($skill, $xp, $mid=TGC_Commands::DEFAULT_MID)
	{
		$this->increase('p_'.$skill.'_xp', $xp);
		if ($this->rehashSkill($skill)) {
			$this->onLevelChanged($skill, $mid);
		}
	}
	
}
