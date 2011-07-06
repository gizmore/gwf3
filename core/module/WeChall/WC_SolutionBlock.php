<?php
final class WC_SolutionBlock extends GDO
{
	const MAX_ANSWERS = 6;
	const MAX_TIMEOUT = 600;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_solution_block'; }
	public function getColumnDefines()
	{
		return array(
			'wcsb_uid' => array(GDO::UINT|GDO::INDEX, 0),
			'wcsb_ip' => GWF_IP6::gdoDefine(GWF_IP6::BIN_32_128, GDO::NOT_NULL, GDO::INDEX),
			'wcsb_time' => array(GDO::TIME|GDO::INDEX, GDO::NOT_NULL),
		);
	}
	
	public static function cleanup()
	{
		$cut = time() - self::MAX_TIMEOUT;
		self::table(__CLASS__)->deleteWhere("wcsb_time<$cut");
	}
	
	public static function isBlocked($user)
	{
		$table = self::table(__CLASS__);
		
		$ip = GWF_IP6::getIP(GWF_IP6::BIN_32_128);
		$eip = $table->escape($ip);
		$cut = time() - self::MAX_TIMEOUT;
		$count = $table->countRows("wcsb_ip='$eip' AND wcsb_time>$cut");
		
		if ($count >= self::MAX_ANSWERS)
		{
			$min = $table->selectMin('wcsb_time', "wcsb_ip='$eip' AND wcsb_time>$cut");
			return $min + self::MAX_TIMEOUT - time();
		}
		
		$row = new self(array(
			'wcsb_uid' => $user === false ? 0 : $user->getID(),
			'wcsb_ip' => $ip,
			'wcsb_time' => time(),
		));
		if (false === $row->insert()) {
			return false;
		}
		
		return false;
	}
}
?>