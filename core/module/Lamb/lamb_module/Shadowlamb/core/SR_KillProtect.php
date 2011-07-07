<?php
final class SR_KillProtect extends GDO
{
	const MAX_LEVEL_DIFF = 20;
	const KILL_TIMEOUT_MIN = 3600; # 1h
	const KILL_TIMEOUT_ADD = 7200; # 1h
	const KILL_TIMEOUT_AVG = 6000; # 4h
	const KILL_TIMEOUT_MAX = 200000; # 2d
	
	private static $CACHE = array();
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_killprotect'; }
	public function getColumnDefines()
	{
		return array(
			'sr4kp_killer' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4kp_victim' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4kp_srtime' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	private static function getCut()
	{
		return Shadowrun4::getTime();
	}
	
	private static function cleanup()
	{
		$cut = self::getCut();
		self::table(__CLASS__)->deleteWhere("sr4kp_srtime<{$cut}");
	}
	
	private static function refreshCache()
	{
		self::$CACHE = self::table(__CLASS__)->selectColumn('CONCAT(sr4kp_killer,":",sr4kp_victim,":",sr4kp_srtime)');
	}
	
	private static function isKillProtectedB(SR_Player $killer, SR_Player $victim)
	{
		if ( ($killer->isNPC()) || ($victim->isNPC()) )
		{
			return false;
		}
		foreach (self::$CACHE as $entry)
		{
			$search = $killer->getID().':'.$victim->getID().':';
			$pos = strpos($entry, $search);
			if ($pos !== false)
			{
				return (int)substr($entry, strlen($search));
			}
		}
		
		return false;
	}
	
	/**
	 * Check if we have a time based kill protection.
	 * @param SR_Player $killer
	 * @param SR_Player $victim
	 */
	public static function isKillProtected(SR_Player $killer, SR_Player $victim)
	{
		self::cleanup();
		self::refreshCache();
		return self::isKillProtectedB($killer, $victim);
	}
	
	public static function onKilled(SR_Player $killer, SR_Player $victim)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'sr4kp_killer' => $killer->getID(),
			'sr4kp_victim' => $victim->getID(),
			'sr4kp_srtime' => Shadowrun4::getTime() + self::getKillTime($killer, $victim),
		));
	}
	
	private static function getKillTime(SR_Player $killer, SR_Player $victim)
	{
		$kl = $killer->get('level');
		$vl = $victim->get('level');
		$diff = $kl - $vl;
		$add = self::KILL_TIMEOUT_ADD * $diff;
		$time = self::KILL_TIMEOUT_AVG + $add;
		$time = Common::clamp($time, self::KILL_TIMEOUT_MIN, self::KILL_TIMEOUT_MAX);
		return round($time);
	}
	
	/**
	 * Check if we have a time based kill protection.
	 * @param SR_Party $attackers
	 * @param SR_Party $defenders
	 * @return int seconds timout
	 */
	public static function isKillProtectedParty(SR_Party $attackers, SR_Party $defenders)
	{
		self::cleanup();
		self::refreshCache();
		foreach ($attackers->getMembers() as $killer)
		{
			foreach ($defenders->getMembers() as $victim)
			{
				if (false !== ($time = self::isKillProtectedB($killer, $victim)))
				{
					return $time;
				}
			}
		}
		return false;
	}
	
	/**
	 * Check if the party sum levels match nicely.
	 * @param SR_Party $attackers
	 * @param SR_Party $defenders
	 * @param boolean $verbose
	 * @return true|false
	 */
	public static function isKillProtectedPartyLevel(SR_Party $attackers, SR_Party $defenders, $verbose=true)
	{
		# NPC
		if (!$defenders->isHuman())
		{
			return false;
		}
		
		# A member as bounty
		foreach ($defenders->getMembers() as $defender)
		{
			$defender instanceof SR_Player;
			if ($defender->getBase('bounty') > 0)
			{
				return false;
			}
		}
		
		# Check party sums
		$al = $attackers->getSum('level');
		$dl = $defenders->getSum('level');
		$dif = $al - $dl;
		if ($dif > self::MAX_LEVEL_DIFF)
		{
			if ($verbose)
			{
				$attackers->getLeader()->message(sprintf('Your party (level sum %d) cannot attack a party with level sum %d because the level difference is larger than %d.', $al, $dl, self::MAX_LEVEL_DIFF));
			}
			# Protected by level
			return true;
		}
		
		# No protection
		return false;
	}
	
	/**
	 * Check if the player levels match nicely.
	 * @param SR_Party $attackers
	 * @param SR_Party $defenders
	 * @param boolean $verbose
	 * @return true|false
	 */
	public static function isKillProtectedLevel(SR_Player $attacker, SR_Player $defender)
	{
		$al = $attacker->get('level');
		$dl = $defender->get('level');
		$dif = $al - $dl;
		if ($dif > self::MAX_LEVEL_DIFF)
		{
			return true;
		}
		return false;
	}
}

?>
