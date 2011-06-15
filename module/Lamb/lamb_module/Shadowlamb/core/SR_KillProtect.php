<?php
final class SR_KillProtect extends GDO
{
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
		self::$CACHE = self::table(__CLASS__)->selectColumn('CONCAT(sr4kp_killer,":",sr4kp_victim)');
	}
	
	private static function isKillProtectedB(SR_Player $killer, SR_Player $victim)
	{
		if ( ($killer->isNPC()) || ($victim->isNPC()) )
		{
			return false;
		}
		return in_array($killer.':'.$victim, self::$CACHE, true);
	}
	
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
	 * @param unknown_type $attackers
	 * @param unknown_type $defenders
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
				if (self::isKillProtectedB($killer, $victim))
				{
					return true;
				}
			}
		}
		return false;
	}
}

?>
