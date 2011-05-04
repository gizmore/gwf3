<?php
final class PT_IP extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'pt_ip'; }
	public function getColumnDefines()
	{
		return array(
			'ptip_ip' => GWF_IP6::gdoDefine(GWF_IP_QUICK, GDO::NOT_NULL, GDO::PRIMARY_KEY),
			'ptip_time' => array(GDO::DATE|GDO::PRIMARY_KEY, GDO::NOT_NULL, GWF_Date::LEN_HOUR),
		);
	}
	
	public static function collect($ip)
	{
		$entry = new self(array(
			'ptip_ip' => $ip,
			'ptip_time' => GWF_Time::getDate(GWF_Date::LEN_HOUR),
		));
		return $entry->replace();
	}
}
?>