<?php
final class WC_API_Block extends GDO
{
	const BLOCK_TIMEOUT = 300;
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_api_block'; }
	public function getColumnDefines()
	{
		return array(
			'wcab_ip' => GWF_IP6::gdoDefine(GWF_IP6::BIN_32_128, GDO::NOT_NULL, GDO::PRIMARY_KEY),
			'wcab_time' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	public static function getBlockRow()
	{
		return self::table(__CLASS__)->getRow(GWF_IP6::getIP(GWF_IP6::BIN_32_128));
	}
	
	public static function insertBlockRow()
	{
		$row = new self(array(
			'wcab_ip' => GWF_IP6::getIP(GWF_IP6::BIN_32_128),
			'wcab_time' => time(),
		));
		
		if (false === $row->insert()) {
			return false;
		}
		
		return $row;
	}
	
	public static function isBlocked()
	{
		return false;
		
		if (false === ($row = self::getBlockRow())) {
			self::insertBlockRow();
			return false;
		}
		
		$time = $row->getVar('wcab_time');
		if ($time+self::BLOCK_TIMEOUT > time()) {
			return true;
		}
		
		$row->saveVar('wcab_time', time());
		return false;
	}
	
	public static function cleanup()
	{
		$cut = time() - self::BLOCK_TIMEOUT*15;
		return self::table(__CLASS__)->deleteWhere("wcab_time < $cut");
	}
}
?>