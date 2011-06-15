<?php
final class BAIM_MC extends GDO
{
	const DELETED = 0x01;
	const DEMO = 0x02;
	
	const TOKEN_LEN = 12;
	const CHANGE_TIMEOUT = 7200; # 2 hours
	const DEMO_TIMEOUT = 14400; # 3 hours
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'baim_mc'; }
	public function getOptionsName() { return 'bmc_options'; }
	public function getColumnDefines()
	{
		return array(
			'bmc_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'bmc_date' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
			'bmc_token' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, self::TOKEN_LEN),
			'bmc_mc' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 255),
			'bmc_expires' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
			'bmc_options' => array(GDO::UINT, 0),
		);
	}
	###################
	### Convinience ###
	###################
	public function getMC() { return $this->getVar('bmc_mc'); }
	public function getToken() { return $this->getVar('bmc_token'); }
	public function isDemo() { return $this->isOptionEnabled(self::DEMO); }
	public function isDeleted() { return $this->isOptionEnabled(self::DELETED); }
	
	public function changeMC($mc)
	{
		if ($this->isDemo())
		{
			if (false !== self::getBy('bmc_mc', $mc)) {
				return false;
			}
		}
		
		return $this->saveVars(array(
			'bmc_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'bmc_mc' => $mc,
		));
	}
	
	public function canChange()
	{
		# Ugly hackfix for some user -.-
//		if ($this->getVar('bmc_uid') === 215) {
//			return true;
//		}
		
		if (NULL === ($last_change = $this->getVar('bmc_date'))) {
			return true;
		}
		$time = GWF_Time::getTimestamp($last_change);
		return ($time+self::CHANGE_TIMEOUT) < time();
	}
	
	public function displayNextChange()
	{
		if (NULL === ($last_change = $this->getVar('bmc_date'))) {
			return 'ERR 08815b';
		}
		$time = GWF_Time::getTimestamp($last_change);
		$wait = ($time + self::CHANGE_TIMEOUT) - time();
		return GWF_Time::humanDuration($wait);
	}
	##############
	### Static ###
	##############
	public static function isValidMC($mc)
	{
		$len = strlen($mc);
		return $len > 0 && $len < 256;
	}
	
	/**
	 * @param int $userid
	 * @return BAIM_MC
	 */
	public static function getByUID($userid)
	{
		return self::table(__CLASS__)->getRow($userid);
	}
	
	/**
	 * @param GWF_User $user
	 * @return BAIM_MC
	 */
	public static function generate(GWF_User $user, $demo=false)
	{
		$userid = $user->getID();
		if (false === ($row = self::getByUID($userid))) {
			return self::createMCRow($userid, $demo);
		}
		
		if ($row->isDeleted()) {
			return false;
		}
		
		if ($demo === false) {
			if (false === $row->saveOption(self::DEMO, $demo)) {
				return false;
			}
		}
		
		return $row;
	}
	
	public function isExpired()
	{
		if (!$this->isDemo()) {
			return false;
		}
		
		if (NULL === ($expire = $this->getVar('bmc_expires'))) {
			$expire = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()+self::DEMO_TIMEOUT);
			$this->saveVar('bmc_expires', $expire);
		}
		
		return strcmp($expire, GWF_Time::getDate(GWF_Date::LEN_SECOND)) !== 1;
	}
	
	private static function createMCRow($userid, $demo)
	{
		$options = 0;
		$options |= $demo === true ? self::DEMO : 0;
		
		$row = new self(array(
			'bmc_uid' => $userid,
			'bmc_date' => NULL,
			'bmc_token' => Common::randomKey(self::TOKEN_LEN, Common::ALPHANUMUPLOW),
			'bmc_mc' => NULL,
			'bmc_expires' => NULL, #GWF_Time::getDate(GWF_Date::LEN_SECOND, time()+self::DEMO_TIMEOUT),
			'bmc_options' => $options,
		));
		if (false === ($row->insert())) {
			return false;
		}
		return $row;
	}
}
?>