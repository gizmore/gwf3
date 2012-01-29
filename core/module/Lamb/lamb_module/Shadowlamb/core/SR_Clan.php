<?php
final class SR_Clan extends GDO
{
	const MIN_MEMBERCOUNT = 1;
	const MAX_MEMBERCOUNT = 50;
	const MIN_STORAGE = 1000; # 1kg
	const MAX_STORAGE = 500000; # 500kg
	const MIN_MONEY = 10000;
	const MAX_MONEY = 1000000;
	
	const MAX_SLOGAN_LEN = 196;
	
	const MODERATED = 0x01;
	
	const MAX_NAME_LEN = 63;
	const MIN_NAME_LEN = 4;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_clan'; }
	public function getOptionsName() { return 'sr4cl_options'; }
	public function getColumnDefines()
	{
		return array(
			'sr4cl_id' => array(GDO::AUTO_INCREMENT),
			'sr4cl_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, self::MAX_NAME_LEN),
			'sr4cl_founder' => array(GDO::UINT, 0),
			'sr4cl_slogan' => array(GDO::TEXT|GDO::CASE_I|GDO::UTF8),
			'sr4cl_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'sr4cl_members' => array(GDO::UINT, 0),
			'sr4cl_max_members' => array(GDO::UINT, self::MIN_MEMBERCOUNT),
			'sr4cl_storage' => array(GDO::UINT, 0),
			'sr4cl_max_storage' => array(GDO::UINT, self::MIN_STORAGE),
			'sr4cl_money' => array(GDO::UINT, 0),
			'sr4cl_max_money' => array(GDO::UINT, 0),
			'sr4cl_options' => array(GDO::UINT, 0),
		
			'members' => array(GDO::JOIN, GDO::NULL, array('SR_ClanMembers', 'sr4cl_id', 'sr4cm_cid')),
		);
	}

	public function getID() { return $this->getVar('sr4cl_id'); }
	public function getLeaderID() { return $this->getVar('sr4cl_founder'); }
	public function isModerated() { return $this->isOptionEnabled(self::MODERATED); }
	public function getSlogan() { return $this->getVar('sr4cl_slogan'); }
	public function isFullMembers() { return $this->getMembercount() >= $this->getMaxMembercount(); }
	public function isMaxStorage() { return $this->getStorage() >= $this->getMaxStorage(); }
	public function isMaxMoney() { return $this->getNuyen() >= $this->getMaxNuyen(); }
	public function getMembercount() { return $this->getInt('sr4cl_members'); }
	public function getMaxMembercount() { return $this->getInt('sr4cl_max_members'); }
	public function getNuyen() { return $this->getInt('sr4cl_money'); }
	public function getMaxNuyen() { return $this->getInt('sr4cl_max_money'); }
	public function getStorage() { return $this->getInt('sr4cl_storage'); }
	public function getMaxStorage() { return $this->getInt('sr4cl_max_storage'); }
	public function getName() { return $this->getVar('sr4cl_name'); }
	public function displayNuyen() { return Shadowfunc::displayNuyen($this->getNuyen()); }
	public function displayMaxNuyen() { return Shadowfunc::displayNuyen($this->getMaxNuyen()); }
	public function displayStorage() { return Shadowfunc::displayWeight($this->getStorage()); }
	public function displayMaxStorage() { return Shadowfunc::displayWeight($this->getMaxStorage()); }
	public function canHoldMore($weight) { return ($this->getStorage()+$weight) <= $this->getMaxStorage(); }
	/**
	 * Get the leader of this clan.
	 * @return SR_Player
	 */
	public function getLeader()
	{
		$lead_id = $this->getLeaderID();
		if (false === ($leader = Shadowrun4::getPlayerByPID($lead_id)))
		{
			if (false === ($leader = SR_Player::getByID($lead_id)))
			{
				return false;
			}
		}
		return $leader;
	}
	
	/**
	 * Get all online members.
	 * @return array
	 */
	public function getOnlineMembers()
	{
		return SR_ClanMembers::getOnlineMembers($this->getID()); 
	}
	
	/**
	 * Get a clan by name.
	 * @param string $name
	 * @return SR_Clan
	 */
	public static function getByName($name) { return self::table(__CLASS__)->getBy('sr4cl_name', $name); }
	
	/**
	 * Get a clan by player name.
	 * @param string $name
	 * @return SR_Clan
	 */
	public static function getByPName($pname) { return SR_ClanMembers::getClanByPName($pname); }
	
	/**
	 * Get a clan by ID.
	 * @param string $name
	 * @return SR_Clan
	 */
	public static function getByID($id) { return self::table(__CLASS__)->getBy('sr4cl_id', $id); }
	
	/**
	 * Get a clan by player.
	 * @param SR_Player $player
	 * @return SR_Clan
	 */
	public static function getByPlayer(SR_Player $player) { return SR_ClanMembers::getClanByPID($player->getID()); }
	
	/**
	 * Send a join request to the leader.
	 * @param SR_Player $player
	 */
	public function sendRequest(SR_Player $player)
	{
		$requests = GDO::table('SR_ClanRequests');
		if (false === $requests->insertAssoc(array(
			'sr4cr_pid' => $player->getID(),
			'sr4cr_cid' => $this->getID(),
			'sr4cr_pname' => $player->getName(),
		), true))
		{
			return false;
		}
		
		$player->msg('5023');
// 		$player->message(sprintf('Your join request has been sent to the clan leaders.'));
		
		return SR_ClanHistory::onRequest($this, $player);
	}
	
	/**
	 * Make a player join this clan.
	 * @param SR_Player $player
	 */
	public function join(SR_Player $player)
	{
		$members = GDO::table('SR_ClanMembers');
		if (false === $members->insertAssoc(array(
			'sr4cm_pid' => $player->getID(),
			'sr4cm_cid' => $this->getID(),
			'sr4cm_jointime' => Shadowrun4::getTime(),
			'sr4cm_options' => '0',
		), true))
		{
			return false;
		}
		
		if (false === ($this->fixMembercount()))
		{
			return false;
		}
		
		return SR_ClanHistory::onJoin($this, $player);
	}
	
	public function kick(SR_Player $player)
	{
		$cid = $this->getID();
		$pid = $player->getID();
		
		if (false === SR_ClanMembers::removeMember($cid, $pid))
		{
			return false;
		}
		if (false === ($this->fixMembercount()))
		{
			return false;
		}
		if (false === ($new_pid = SR_ClanMembers::computeLeaderID($cid)))
		{
			return false;
		}
		if (false === ($this->saveVar('sr4cl_founder', $new_pid)))
		{
			return false;
		}
		if (false === SR_ClanMembers::setClanOptions($cid, $new_pid, SR_ClanMembers::FOUNDER))
		{
			return false;
		}
		return SR_ClanHistory::onPart($this, $player);
	}
	
	private function fixMembercount()
	{
		return $this->saveVar('sr4cl_members', SR_ClanMembers::countMembers($this->getID()));
	}
	
	public function addWealth($amt)
	{
		$old = $this->getMaxNuyen();
		$new = Common::clamp($old+$amt, self::MIN_MONEY, self::MAX_MONEY);
		return $this->saveVar('sr4cl_max_money', $new);
	}
	
	public function addStorage($amt)
	{
		$old = $this->getMaxStorage();
		$new = Common::clamp($old+$amt, self::MIN_STORAGE, self::MAX_STORAGE);
		return $this->saveVar('sr4cl_max_storage', $new);
	}
	
	public function addMembercount($amt)
	{
		$old = $this->getMaxMembercount();
		$new = Common::clamp($old+$amt, self::MIN_MEMBERCOUNT, self::MAX_MEMBERCOUNT);
		return $this->saveVar('sr4cl_max_members', $new);
	}
	
	public static function create(SR_Player $player, $name)
	{
		$clan = new self(array(
			'sr4cl_id' => '0',
			'sr4cl_name' => $name,
			'sr4cl_founder' => $player->getID(),
			'sr4cl_slogan' => '',
			'sr4cl_date' => GWF_Time::getDate(),
			'sr4cl_members' => '0',
			'sr4cl_max_members' => self::MIN_MEMBERCOUNT,
			'sr4cl_storage' => '0',
			'sr4cl_max_storage' => self::MIN_STORAGE,
			'sr4cl_money' => '0',
			'sr4cl_max_money' => self::MIN_MONEY,
			'sr4cl_options' => '0',
		));
		if (false === $clan->insert())
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		if (false === $clan->join($player))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		if (false === SR_ClanMembers::setClanOptions($clan->getID(), $player->getID(), SR_ClanMembers::FOUNDER))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		if (false === SR_ClanHistory::onCreate($clan, $player))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		return $clan;
	}
}
?>