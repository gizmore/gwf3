<?php
final class Dog_IRCStats extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_ircstats'; }
	public function getColumnDefines()
	{
		return array(
			'dis_sid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'dis_ip' => GWF_IP6::gdoDefine(GWF_IP6::AS_IS, GDO::NULL),
			'dis_software' => array(GDO::VARCHAR|GDO::CASE_I|GDO::UTF8, GDO::NULL, 255),
			'dis_max_users' => array(GDO::UINT, 0),
			'dis_max_chans' => array(GDO::UINT, 0),
			'dis_created_at' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
		);
	}

	public function getID() { return $this->getVar('dis_sid'); }
	
	public static function getByServer(Dog_Server $server)
	{
		return self::table(__CLASS__)->getRow($server->getID());
	}
	
	public static function getOrCreateByServer(Dog_Server $server)
	{
		if (false !== ($stats = self::getByServer($server)))
		{
			return $stats;
		}
		
		$stats = new self(array(
			'dis_sid' => $server->getID(),
			'dis_ip' => NULL,
			'dis_software' => NULL,
			'dis_max_users' => '0',
			'dis_max_chans' => '0',
			'dis_created_at' => NULL,
		));
		
		return $stats->replace() ? $stats : false;
	}
}
?>
