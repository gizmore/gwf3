<?php
final class SR_Tell extends GDO
{
	const MAX_MSGS = 5;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_tell'; }
	public function getColumnDefines()
	{
		return array(
			'sr4tl_pid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'sr4tl_time' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4tl_msg' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		);
	}
	
	public static function onTell(SR_Player $player)
	{
		$pid = $player->getID();
		$where = 'sr4tl_pid='.$pid;
		$table = self::table(__CLASS__);
		if (false === ($result = $table->selectAll('sr4tl_time, sr4tl_msg', $where, 'sr4tl_time DESC', NULL, 10, 0, GDO::ARRAY_N)))
		{
			return false;
		}
		
		foreach (array_reverse($result) as $row)
		{
			$player->message('OldMessage: '.$row[1]);
		}
		
		return $table->deleteWhere($where);
	}
	
	public static function tell($pid, $msg)
	{
// 		print('TELL: '.$msg.PHP_EOL);

		$pid = (int)$pid;
		$table = self::table(__CLASS__);
		
		if (false === $table->insertAssoc(array(
			'sr4tl_pid' => $pid,
			'sr4tl_time' => Shadowrun4::getTime(),
			'sr4tl_msg' => $msg,
		)))
		{
			return false;
		}
		
		$where = "sr4tl_pid={$pid}";
		
		$rows = $table->countRows($where);
		
		if ($rows > self::MAX_MSGS)
		{
// @todo: This is currently broken Oo
//			if (false === $table->deleteWhere($where, 'sr4tl_time ASC', NULL, 5, 0))
//			{
//				return false;
//			}
		}
		return true;
	}
}
?>