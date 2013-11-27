<?php
/**
 * Clan event history.
 * @author gizmore
 */
final class SR_ClanHistory extends GDO
{
	const CREATE = 0;
	const REQUEST = 1;
	const JOIN = 2;
	const PART = 3;
	const MSG = 4;
	const PUSHY = 5;
	const POPY = 6;
	const PUSHI = 7;
	const POPI = 8;
	const ADD_MEMBERS = 9;
	const ADD_WEALTH = 10;
	const ADD_STORAGE = 11;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_clan_history'; }
	public function getColumnDefines()
	{
		return array(
			'sr4ch_id' => array(GDO::AUTO_INCREMENT),
			'sr4ch_cid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'sr4ch_time' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'sr4ch_pname' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, 63),
			'sr4ch_action' => array(GDO::TINYINT|GDO::UNSIGNED, GDO::NOT_NULL),
			'sr4ch_iname' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NULL),
			'sr4ch_amt' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	public function getID() { return $this->getVar('sr4ch_id'); }
	public function getClanID() { return $this->getVar('sr4ch_cid'); }
	public function getTime() { return $this->getVar('sr4ch_time'); }
	public function getPName() { return $this->getVar('sr4ch_pname'); }
	public function getAction() { return $this->getVar('sr4ch_action'); }
	public function getIName() { return $this->getVar('sr4ch_iname'); }
	public function getAmt() { return $this->getVar('sr4ch_amt'); }
	public function getMessage(SR_Player $player) { return self::getHistMessage($player, $this->getTime(), $this->getPName(), $this->getAction(), $this->getIName(), $this->getAmt()); }
	
	/**
	 * Get a row by ID.
	 * @param int $id
	 * @return SR_ClanHistory
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	
	/**
	 * Get text message for an event.
	 * @param int $time
	 * @param string $pname
	 * @param int $action
	 * @param string $iname
	 * @param int $amt
	 * @return string
	 */
	public static function getHistMessage(SR_Player $player, $time, $pname, $action, $iname, $amt)
	{
		$key = 'ch_'.$action;
		switch ($action)
		{
			case self::CREATE: $args = array($pname, $iname); break;
			case self::REQUEST:
			case self::JOIN:
			case self::PART: $args = array($pname, $amt); break;
			case self::MSG: $args = array($pname, $iname); break;
			case self::PUSHY:
			case self::POPY: $args = array($pname, Shadowfunc::displayNuyen($amt)); break;
			case self::PUSHI:
			case self::POPI: $args = array($pname, $amt, $iname); break;
			case self::ADD_MEMBERS: $args = array($pname, $amt); break;
			case self::ADD_WEALTH: $args = array($pname, Shadowfunc::displayNuyen($amt)); break;
			case self::ADD_STORAGE: $args = array($pname, Shadowfunc::displayWeight($amt)); break;
// 			case self::CREATE: return sprintf('%s created the clan %s.', $pname, $iname);
// 			case self::REQUEST: return sprintf('%s requested to join your clan as member #%s.', $pname, $amt);
// 			case self::JOIN: return sprintf('%s has joined your clan as member #%s.', $pname, $amt);
// 			case self::PART: return sprintf('%s has left your clan and it now holds %s members.', $pname, $amt);
// 			case self::MSG: return sprintf("\X02%s\X02: \"%s\"", $pname, $iname);
// 			case self::PUSHY: return sprintf('%s has pushed %s into the clanbank.', $pname, Shadowfunc::displayNuyen($amt));
// 			case self::POPY: return sprintf('%s has taken %s out of the clanbank.', $pname, Shadowfunc::displayNuyen($amt));
// 			case self::PUSHI: return sprintf('%s has put %s %s into the clanbank.', $pname, $amt, $iname);
// 			case self::POPI: return sprintf('%s has taken %s %s out of the clanbank.', $pname, $amt, $iname);
// 			case self::ADD_MEMBERS: return sprintf('%s has purchased more member slots and the clan can now hold up to %s.', $pname, $amt);
// 			case self::ADD_WEALTH: return sprintf('%s has purchased more nuyen capacity and the clan can now hold up to %s.', $pname, Shadowfunc::displayNuyen($amt));
// 			case self::ADD_STORAGE: return sprintf('%s has purchased more storage room and the clan can now hold up to %s.', $pname, Shadowfunc::displayWeight($amt));
			default: return 'ERR ACTION: '.$action;
		}
		return $player->lang($key, $args);
	}
	
	public static function insertAndSend(SR_Clan $clan, SR_ClanHistory $event)
	{
		return false === $event->insert() ? false : self::sendEvent($clan, $event);
	}
	
	public static function sendEvent(SR_Clan $clan, SR_ClanHistory $event)
	{
		foreach ($clan->getOnlineMembers() as $member)
		{
			$member instanceof SR_Player;
			$member->msg('5258', array($event->getMessage($member)));
		}
		return true;
	}
	
	###############
	### Helpers ###
	###############
	public static function onCreate(SR_Clan $clan, SR_Player $player)
	{
		$event = new self(array(
			'sr4ch_id' => '0',
			'sr4ch_cid' => $clan->getID(),
			'sr4ch_time' => Shadowrun4::getTime(),
			'sr4ch_pname' => $player->getName(),
			'sr4ch_action' => self::CREATE,
			'sr4ch_iname' => $clan->getName(),
			'sr4ch_amt' => '1',
		));
		return self::insertAndSend($clan, $event);
	}

	public static function onRequest(SR_Clan $clan, SR_Player $player)
	{
		$event = new self(array(
			'sr4ch_id' => '0',
			'sr4ch_cid' => $clan->getID(),
			'sr4ch_time' => Shadowrun4::getTime(),
			'sr4ch_pname' => $player->getName(),
			'sr4ch_action' => self::REQUEST,
			'sr4ch_iname' => NULL,
			'sr4ch_amt' => $clan->getMembercount()+1,
		));
		return self::insertAndSend($clan, $event);
	}

	public static function onJoin(SR_Clan $clan, SR_Player $player)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::JOIN,
				'sr4ch_iname' => NULL,
				'sr4ch_amt' => $clan->getMembercount(),
		));
		return self::insertAndSend($clan, $event);
	}
	
	public static function onPart(SR_Clan $clan, SR_Player $player)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::PART,
				'sr4ch_iname' => NULL,
				'sr4ch_amt' => $clan->getMembercount(),
		));
		return self::insertAndSend($clan, $event);
	}

	public static function onMessage(SR_Clan $clan, SR_Player $player, $message)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::MSG,
				'sr4ch_iname' => $message,
				'sr4ch_amt' => '0',
		));
		return self::insertAndSend($clan, $event);
	}
	
	public static function onPushy(SR_Clan $clan, SR_Player $player, $amt)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::PUSHY,
				'sr4ch_iname' => NULL,
				'sr4ch_amt' => $amt,
		));
		return self::insertAndSend($clan, $event);
	}
	
	public static function onPopy(SR_Clan $clan, SR_Player $player, $amt)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::POPY,
				'sr4ch_iname' => NULL,
				'sr4ch_amt' => $amt,
		));
		return self::insertAndSend($clan, $event);
	}
	
	public static function onPushi(SR_Clan $clan, SR_Player $player, $iname, $amt)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::PUSHI,
				'sr4ch_iname' => $iname,
				'sr4ch_amt' => $amt,
		));
		return self::insertAndSend($clan, $event);
	}
	
	public static function onPopi(SR_Clan $clan, SR_Player $player, $iname, $amt)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::POPI,
				'sr4ch_iname' => $iname,
				'sr4ch_amt' => $amt,
		));
		return self::insertAndSend($clan, $event);
	}
	
	public static function onAddMembers(SR_Clan $clan, SR_Player $player)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::ADD_MEMBERS,
				'sr4ch_iname' => NULL,
				'sr4ch_amt' => $clan->getMaxMembercount(),
		));
		return self::insertAndSend($clan, $event);
	}
	
	public static function onAddWealth(SR_Clan $clan, SR_Player $player)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::ADD_WEALTH,
				'sr4ch_iname' => NULL,
				'sr4ch_amt' => $clan->getMaxNuyen(),
		));
		return self::insertAndSend($clan, $event);
	}
	
	public static function onAddStorage(SR_Clan $clan, SR_Player $player)
	{
		$event = new self(array(
				'sr4ch_id' => '0',
				'sr4ch_cid' => $clan->getID(),
				'sr4ch_time' => Shadowrun4::getTime(),
				'sr4ch_pname' => $player->getName(),
				'sr4ch_action' => self::ADD_STORAGE,
				'sr4ch_iname' => NULL,
				'sr4ch_amt' => $clan->getMaxStorage(),
		));
		return self::insertAndSend($clan, $event);
	}
}
?>