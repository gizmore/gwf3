<?php
/**
 * Holds records for user join/quit fastest times.
 * @author gizmore
 */
final class Lamb_QuitJoinChannel extends Lamb_QuitJoin
{
	const ENABLED = 1;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_quit_join_c'; }
	public function getOptionsName() { return 'lqj_options'; }
	public function getColumnDefines()
	{
		return array(
			'lqj_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lqj_sid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'lqj_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'lqj_duration' => array(GDO::DECIMAL|GDO::INDEX, GDO::NOT_NULL, array(4,4)),
			'lqj_date_quit' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_MILLI),
			'lqj_date_join' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_MILLI),
			'lqj_options' => array(GDO::UINT|GDO::INDEX, 0),
		);
	}
	
//	public static function getUserRecord()
//	{
//		return self::table(__CLASS__)->getRow(self::$USER->getID(), self::$CHANNEL->getID());
//	}
	
	public static function isChannelEnabled(Lamb_Channel $channel)
	{
		$cid = $channel->getID();
		$enabled = self::ENABLED;
		return self::table(__CLASS__)->selectVar('1', "lqj_cid={$cid} AND lqj_options&{$enabled}") === '1';
	}
	
	public static function isChannelRecord(Lamb_Channel $channel, $duration)
	{
		if (false === ($row = self::getChannelRecord($channel))) {
			return true;
		}
		return $duration < $row->getVar('lqj_duration');
	}
	
	public static function getChannelRecord(Lamb_Channel $channel)
	{
		return self::table(__CLASS__)->getBy('lqj_cid', $channel->getID());
	}
	
	public static function getOrCreateRow(Lamb_Channel $channel)
	{
		if (false !== ($row = self::getChannelRecord($channel))) {
			return $row;
		}
		
		return self::createChannelRecord($channel);
	}
	
	public static function createChannelRecord(Lamb_Channel $channel)
	{
		$row = new self(array(
			'lqj_cid' => $channel->getID(),
			'lqj_sid' => $channel->getVar('chan_sid'),
			'lqj_uid' => 0,
			'lqj_duration' => 9999.9999,
			'lqj_date_quit' => str_repeat('0',14),
			'lqj_date_join' => str_repeat('0',14),
			'lqj_options' => 0,
		));
		if (false === $row->replace()) {
			return false;
		}
		return $row;
		
	}
	
	public function displayUser()
	{
		$id = $this->getVar('lqj_uid');
		return GDO::table('Lamb_User')->selectVar('lusr_name', "lusr_id={$id}");
	}

	public function displayChannel()
	{
		$id = $this->getVar('lqj_cid');
		return GDO::table('Lamb_Channel')->selectVar('chan_name', "chan_id={$id}");
	}
	
	public function displayServer()
	{
		$id = $this->getVar('lqj_sid');
		return GDO::table('Lamb_Server')->selectVar('serv_name', "serv_id={$id}");
	}
	
	public function displayTime()
	{
		return sprintf('%.03fs', $this->getVar('lqj_duration'));
	}
}
?>