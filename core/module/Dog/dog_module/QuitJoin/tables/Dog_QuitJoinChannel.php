<?php
/**
 * Holds channel records for user join/quit fastest times.
 * @author gizmore
 */
final class Dog_QuitJoinChannel extends Dog_QuitJoin
{
	const ENABLED = 1;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_quit_join_c'; }
	public function getOptionsName() { return 'dqj_options'; }
	public function getColumnDefines()
	{
		return array(
			'dqj_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'dqj_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'dqj_duration' => array(GDO::DECIMAL|GDO::INDEX, GDO::NOT_NULL, array(4,4)),
			'dqj_date_quit' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_MILLI),
			'dqj_date_join' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_MILLI),
			'dqj_options' => array(GDO::UINT|GDO::INDEX, 0),
		);
	}
	
	public static function isChannelEnabled(Dog_Channel $channel)
	{
		$cid = $channel->getID();
		$enabled = self::ENABLED;
		return self::table(__CLASS__)->selectVar('1', "dqj_cid={$cid} AND dqj_options&{$enabled}") === '1';
	}
	
	public static function isChannelRecord(Dog_Channel $channel, $duration)
	{
		if (false === ($row = self::getChannelRecord($channel))) {
			return true;
		}
		return $duration < $row->getVar('dqj_duration');
	}
	
	public static function getChannelRecord(Dog_Channel $channel)
	{
		return self::table(__CLASS__)->getBy('dqj_cid', $channel->getID());
	}
	
	public static function getOrCreateRow(Dog_Channel $channel)
	{
		if (false !== ($row = self::getChannelRecord($channel))) {
			return $row;
		}
		
		return self::createChannelRecord($channel);
	}
	
	public static function createChannelRecord(Dog_Channel $channel)
	{
		$row = new self(array(
			'dqj_cid' => $channel->getID(),
			'dqj_sid' => $channel->getVar('chan_sid'),
			'dqj_uid' => 0,
			'dqj_duration' => 9999.9999,
			'dqj_date_quit' => str_repeat('0',14),
			'dqj_date_join' => str_repeat('0',14),
			'dqj_options' => 0,
		));
		if (false === $row->replace()) {
			return false;
		}
		return $row;
		
	}
	
	public function displayUser()
	{
		$id = $this->getVar('dqj_uid');
		return GDO::table('Dog_User')->selectVar('user_name', "user_id={$id}");
	}

	public function displayChannel()
	{
		$id = $this->getVar('dqj_cid');
		return GDO::table('Dog_Channel')->selectVar('chan_name', "chan_id={$id}");
	}
	
	public function displayServer()
	{
		$id = $this->getVar('dqj_sid');
		return GDO::table('Dog_Server')->selectVar('serv_host', "serv_id={$id}");
	}
	
	public function displayTime()
	{
		return sprintf('%.03fs', $this->getVar('dqj_duration'));
	}
}
?>
