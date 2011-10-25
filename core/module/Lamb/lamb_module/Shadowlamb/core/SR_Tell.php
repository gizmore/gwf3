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
//		printf("ON TELL\n");
//		return true;
		$pid = $player->getID();
		$where = 'sr4tl_pid='.$pid;
		$table = self::table(__CLASS__);
		if (false === ($result = $table->select('sr4tl_time, sr4tl_msg', $where, 'sr4tl_time ASC')))
		{
			return false;
		}
		
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_N)))
		{
//			$player->message('TELLv1: '.$row[1]);
			$player->message($row[1]);
		}
		
		$table->free($result);
		
		return $table->deleteWhere($where);
	}
	
	public static function tell($pid, $msg)
	{
		print('TELL: '.$msg.PHP_EOL);
//		return true;

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
			if (false === $table->deleteWhere($where, 'sr4tl_time ASC', NULL, $rows-self::MAX_MSGS, 0))
			{
				return false;
			}
			
		}
		
		
		return true;
	}
}
?>