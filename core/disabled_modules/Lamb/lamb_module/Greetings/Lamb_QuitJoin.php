<?php
/**
 * Holds records for user join/quit fastest times.
 * @author gizmore
 */
class Lamb_QuitJoin extends GDO
{
	CONST NOTEWORTHY = 10; # 10 Seconds is good. 
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_quit_join'; }
	public function getColumnDefines()
	{
		return array(
			'lqj_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lqj_cid' => array(GDO::UINT, GDO::NOT_NULL),
			'lqj_duration' => array(GDO::DECIMAL|GDO::INDEX, GDO::NOT_NULL, array(4,4)),
			'lqj_date_quit' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_MILLI),
			'lqj_date_join' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_MILLI),
		);
	}
	
	###################
	### QUIT / JOIN ###
	###################
	protected static $JOIN = array();
	
	public static function onJoin(Lamb $bot, Lamb_Server $server, Lamb_Channel $channel, Lamb_User $user)
	{
		if (!Lamb_QuitJoinChannel::isChannelEnabled($channel)) {
			return false;
		}
		
		$uid = $user->getID();
		$cid = $channel->getID();
		
		if (!isset(self::$JOIN[$cid])) {
			self::$JOIN[$cid] = array();
		}

		self::$JOIN[$cid][$uid] = array(GWF_Time::getDateMillis(), microtime(true));
	}
	
	private static function stopTheWatch(Lamb_User $user, Lamb_Channel $channel)
	{
		$uid = $user->getID();
		$cid = $channel->getID();
		return isset(self::$JOIN[$cid][$uid]) ? self::$JOIN[$cid][$uid] : false;
	}
	
	public static function onQuit(Lamb $bot, Lamb_Server $server, Lamb_Channel $channel, Lamb_User $user)
	{
		if (!Lamb_QuitJoinChannel::isChannelEnabled($channel)) {
			return false;
		}
		
		if (false === ($start = self::stopTheWatch($user, $channel)))
		{
			echo "No join set in ".__METHOD__.PHP_EOL;
			return;
		}
		
		// Is below 10s or something?
		$end = microtime(true);
		$enddate = GWF_Time::getDateMillis($end);
		$dur = $end - $start[1];
		if ($dur > self::NOTEWORTHY)
		{
// 			echo "{$uname} quitjoin time: {$dur}s.\n";
			return;
		}

		// A channel record \o/
		if (Lamb_QuitJoinChannel::isChannelRecord($channel, $dur))
		{
			if (false === GDO::table('Lamb_QuitJoinChannel')->insertAssoc(array(
				'lqj_cid' => $channel->getID(),
				'lqj_sid' => $server->getID(),
				'lqj_uid' => $user->getID(),
				'lqj_duration' => $dur,
				'lqj_date_quit' => $enddate,
				'lqj_date_join' => $start[0],
			), true)) {
				return;
			}
			$message = sprintf('%s just broke the channel record in channel %s: %.03f.', $user->getName(), $channel->getName(), $dur);
			$server->sendPrivmsg($channel->getName(), $message);
		}
		
		// A personal record \o/
		elseif (Lamb_QuitJoin::isPersonalRecord($user, $dur, $start[0], $enddate))
		{
			$message = sprintf('%s just scored a new personal record in channel %s: %.03fs.', $user->getName(), $channel->getName(), $dur);
			$server->sendPrivmsg($channel->getName(), $message);
		}
	}
	
	################
	### Personal ###
	################
	public static function getUserRecord(Lamb_User $user)
	{
		return self::table(__CLASS__)->getRow($user->getID());
	}
	
	public static function isPersonalRecord(Lamb_User $user, $dur, $startdate, $enddate)
	{
		if ( (false === ($record = self::getUserRecord($user))) || ($record->getVar('lqj_duration') > $dur) )
		{
			if (false === self::table(__CLASS__)->insertAssoc(array(
				'lqj_uid' => $user->getID(),
				'lqj_cid' => Lamb::instance()->getCurrentChannel()->getID(),
				'lqj_duration' => $dur,
				'lqj_date_quit' => $enddate,
				'lqj_date_join' => $startdate,
			), true)) {
				return false;
			}
			
			return true;
		}
		
		return $dur < $record->getVar('lqj_duration');
	}

}
?>