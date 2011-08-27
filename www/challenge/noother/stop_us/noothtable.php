<?php
final class noothtable extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wcc_stop_us'; }
	public function getColumnDefines()
	{
		return array(
			'sid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'money' => array(GDO::INT, 0),
			'fundings' => array(GDO::INT, 0),
			'domains' => array(GDO::UINT, 0),
			'timestamp' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	public static function initNoothworks($sid)
	{
		if (false === self::table(__CLASS__)->selectVar('1', "sid={$sid}"))
		{
			return self::table(__CLASS__)->insertAssoc(array(
				'sid' => $sid,
				'money' => 0,
				'fundings' => 0,
				'domains' => 0,
				'timestamp' => 0,
			));
		}
		return true;
	}
	
	public static function increaseMoney($sid, $money=10)
	{
		$sid = (int)$sid;
		$money = (int)$money;
		$time = time();
		return self::table(__CLASS__)->update("money=money+{$money}, fundings=fundings+1", "sid={$sid}");
	}
	
	public static function getMoney($sid)
	{
		$sid = (int)$sid;
		return self::table(__CLASS__)->selectVar('money', "sid={$sid}");
	}

	public static function getFundings($sid)
	{
		$sid = (int)$sid;
		return self::table(__CLASS__)->selectVar('fundings', "sid={$sid}");
	}

	public static function getDomains($sid)
	{
		$sid = (int)$sid;
		return self::table(__CLASS__)->selectVar('domains', "sid={$sid}");
	}

	public static function getTimestamp($sid)
	{
		$sid = (int)$sid;
		return self::table(__CLASS__)->selectVar('timestamp', "sid={$sid}");
	}
	
	public static function checkTimeout($sid, $time)
	{
		$elapsed = time() - self::getTimestamp($sid);
		self::table(__CLASS__)->update("timestamp=".time(), "sid={$sid}");
		return 45 - $elapsed;
	}
	
	public static function purchaseDomain($sid, $price=10)
	{
		$sid = (int)$sid;
		$price = (int)$price;
		$time = time();
		return self::table(__CLASS__)->update("domains=domains+1", "sid={$sid} AND money>={$price}");
	}

	public static function reduceMoney($sid, $price=10)
	{
		$sid = (int)$sid;
		$price = (int)$price;
		$time = time();
		return self::table(__CLASS__)->update("money=money-{$price}", "sid={$sid}");
	}
}
?>