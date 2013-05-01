<?php
final class SR_NoShout extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_noshout'; }
	public function getColumnDefines()
	{
		return array(
			'sr4ns_pid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4ns_ends' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	public static function setShout($pid)
	{
		$pid = (int)$pid;
		return self::table(__CLASS__)->deleteWhere("sr4ns_pid=$pid");
	}
	
	public static function setNoShout($pid, $seconds=-1)
	{
		$ends = $seconds < 0 ? 0 : Shadowrun4::getTime() + $seconds;
		return self::table(__CLASS__)->insertAssoc(array(
			'sr4ns_pid' => $pid,
			'sr4ns_ends' => $ends,
		), true);
	}
	
	public static function isNoShout($pid)
	{
		$pid = (int)$pid;
		if (false === ($ends = self::table(__CLASS__)->selectVar('sr4ns_ends', "sr4ns_pid=$pid"))) {
			return -1;
		}
		if ($ends == 0) {
			return GWF_Time::ONE_DAY;
		}
		return $ends - Shadowrun4::getTime();
	}
}
?>