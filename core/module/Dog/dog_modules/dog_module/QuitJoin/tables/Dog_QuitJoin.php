<?php
/**
 * Holds user records for user join/quit fastest times.
 * @author gizmore
 */
class Dog_QuitJoin extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_quit_join'; }
	public function getColumnDefines()
	{
		return array(
			'dqj_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'dqj_cid' => array(GDO::UINT, GDO::NOT_NULL),
			'dqj_duration' => array(GDO::DECIMAL|GDO::INDEX, GDO::NOT_NULL, array(4,4)),
			'dqj_date_quit' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_MILLI),
			'dqj_date_join' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_MILLI),
		);
	}
	
	###################
	### QUIT / JOIN ###
	###################
	protected static $JOIN = array();
	
	public static function onJoin(Dog_Server $server, Dog_Channel $channel, Dog_User $user)
	{
		$uid = $user->getID();
		$cid = $channel->getID();
		
		if (!isset(self::$JOIN[$cid]))
		{
			self::$JOIN[$cid] = array();
		}

		self::$JOIN[$cid][$uid] = array(GWF_Time::getDateMillis(), microtime(true));
		
// 		printf("START JOIN [%s][%s] with %s and %s\n", $cid, $uid, GWF_Time::getDateMillis(), microtime(true));
	}
	
	private static function stopTheWatch(Dog_User $user, Dog_Channel $channel)
	{
		$uid = $user->getID();
		$cid = $channel->getID();
		return isset(self::$JOIN[$cid][$uid]) ? self::$JOIN[$cid][$uid] : false;
	}
	
	public static function onQuit(DOGMOD_QuitJoin $QUITJOIN, Dog_Server $server, Dog_User $user)
	{
		$noteworthy = $QUITJOIN->getConfig('noteworthy', 's');
		
		foreach ($server->getChannels() as $channel)
		{
			$channel instanceof Dog_Channel;
			if ($channel->getUserByID($user->getID()) !== false)
			{
				if (!Dog_Conf_Mod_Chan::isModuleDisabled('QuitJoin', $channel->getID()))
				{
					self::onQuitChannel($QUITJOIN, $server, $channel, $user, $noteworthy);
				}
			}
		}
	}
	
	private static function onQuitChannel(DOGMOD_QuitJoin $QUITJOIN, Dog_Server $server, Dog_Channel $channel, Dog_User $user, $noteworthy)
	{
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
		if (Dog_QuitJoinChannel::isChannelRecord($channel, $dur))
		{
			if (false === GDO::table('Dog_QuitJoinChannel')->insertAssoc(array(
				'dqj_uid' => $user->getID(),
				'dqj_cid' => $channel->getID(),
				'dqj_duration' => $dur,
				'dqj_date_quit' => $enddate,
				'dqj_date_join' => $start[0],
			), true)) {
				return;
			}
			$channel->sendPRIVMSG($QUITJOIN->lang('broke_channel', array($user->displayName(), $channel->displayName(), $dur)));
		}
		
		// A personal record \o/
		elseif (Dog_QuitJoin::isPersonalRecord($user, $dur, $start[0], $enddate))
		{
			$channel->sendPRIVMSG($QUITJOIN->lang('broke_personal', array($user->displayName(), $channel->displayName(), $dur)));
		}
	}
	
	################
	### Personal ###
	################
	public static function getUserRecord(Dog_User $user)
	{
		return self::table(__CLASS__)->getRow($user->getID());
	}
	
	public static function isPersonalRecord(Dog_User $user, $dur, $startdate, $enddate)
	{
		if ( (false === ($record = self::getUserRecord($user))) || ($record->getVar('dqj_duration') > $dur) )
		{
			if (false === self::table(__CLASS__)->insertAssoc(array(
				'dqj_uid' => $user->getID(),
				'dqj_cid' => Dog::getChannel()->getID(),
				'dqj_duration' => $dur,
				'dqj_date_quit' => $enddate,
				'dqj_date_join' => $startdate,
			), true)) {
				return false;
			}
			
			return true;
		}
		
		return $dur < $record->getVar('dqj_duration');
	}
}
?>
