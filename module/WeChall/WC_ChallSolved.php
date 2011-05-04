<?php
/**
 * Have you solved a challenge?
 * It now keeps track on how long you "think of a challenge".
 * The old Solved table also kept the voting, which is now implemented with help of the voting module.
 * The voting tables are disabled, and a wrapper is implemented in module wechall, to restrict votes to solvers.
 * @author gizmore
 */
final class WC_ChallSolved extends GDO
{
	const VOTED = 0x01;
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_chall_solved'; }
	public function getOptionsName() { return 'csolve_options'; }
	public function getColumnDefines()
	{
		return array(
			'csolve_uid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'csolve_cid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'csolve_date' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
			'csolve_1st_look' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'csolve_viewcount' => array(GDO::UINT, 0),
			'csolve_options' => array(GDO::UINT, 0),
			'csolve_time_taken' => array(GDO::UINT, 0),
			'csolve_tries' => array(GDO::UINT, 0),
		);
	}
	
//	public function isSolved() { return $this->getVar('csolve_date') !== NULL; }
	public function hasVoted() { return $this->isOptionEnabled(self::VOTED); }
	
	##################
	### Static Get ###
	##################
	/**
	 * Get number of solved challenges for a user.
	 * @param int $userid
	 * @return int
	 */
	public static function getSolvedCount($userid)
	{
		return self::table(__CLASS__)->countRows("csolve_uid=$userid AND csolve_date!=''");
	}
	
	/**
	 * Get the solved entry for this user/challenge. On first call we store the "1st_look_at" date.
	 * @param unknown_type $userid
	 * @param unknown_type $challid
	 * @return unknown_type
	 */
	public static function getSolvedRow($userid, $challid)
	{
		if ($userid <= 0 || $challid <= 0) {
			return false;
		}
		
		if (false === ($row = GDO::table(__CLASS__)->getRow($userid, $challid))) {
			return self::createSolvedRow($userid, $challid);
		}
		
//		$row->increase('csolve_viewcount');
		
		return $row;
	}
	
	public static function createSolvedRow($userid, $challid)
	{
		$back = new self(array(
			'csolve_uid' => $userid,
			'csolve_cid' => $challid,
			'csolve_date' => '',
			'csolve_1st_look' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'csolve_viewcount' => 1,
			'csolve_options' => 0,
			'csolve_time_taken' => 0,
			'csolve_tries' => 0,
		));
		return $back->replace() !== false ? $back : false;
	}

	/**
	 * Get all solved rows for a user.
	 * @param int $userid
	 * @return array
	 */
	public static function getSolvedForUser($userid, $solved_only=true)
	{
		$solve = $solved_only ? " AND csolve_date != ''" : '';
		$result = GDO::table(__CLASS__)->queryAll("csolve_uid=$userid$solve");#, 'csolve_cid ASC');
		$back = array();
		foreach ($result as $row)
		{
			$back[(int)$row['csolve_cid']] = $row;
		}
		return $back;
	}
	
	public static function hasSolved($userid, $challid)
	{
		if (false === ($row = self::getSolvedRow($userid, $challid))) {
			return false;
		}
		return $row->isSolved();
	}
	
	
	###################
	### Convinience ###
	###################
	/**
	 * @return WC_Challenge
	 */
	public function getChallenge()
	{
		return WC_Challenge::getByID($this->getChallID());
	}
	public function getChallID()
	{
		return $this->getVar('csolve_cid');
	}
	
	public function isSolved()
	{
		return $this->getVar('csolve_date') !== '';
	}
	
	public function markSolved()
	{
		$now = GWF_Time::getDate(GWF_Date::LEN_SECOND);
		return $this->saveVars(array(
			'csolve_date' => $now,
			'csolve_time_taken' => $this->calcTimeTaken($now),
		));
	}
	
	public function calcTimeTaken($now)
	{
		return GWF_Time::getTimestamp($now) - GWF_Time::getTimestamp($this->getVar('csolve_1st_look'));
	}
	
	#################
	### Set Voted ###
	#################
	public static function setVoted($userid, $challid, $bool)
	{
		if (false === ($row = self::getSolvedRow($userid, $challid))) {
			return false;
		}
		return $row->saveOption(self::VOTED, $bool);
	}
}

?>