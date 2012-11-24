<?php
/**
 * Check the channel peak on join.
 * @author gizmore
 */
final class Dog_ChannelPeak extends GDO
{
	const ENABLED = 1;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_channel_peak'; }
	public function getOptionsName() { return 'lcpeak_options'; }
	public function getColumnDefines()
	{
		return array(
			'lcpeak_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lcpeak_peak' => array(GDO::UINT, 0),
			'lcpeak_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'lcpeak_options' => array(GDO::UINT, 0),
		);
	}
	
	public function isEnabled() { return $this->isOptionEnabled(self::ENABLED); }
	
	############
	### JOIN ###
	############
	public static function onJoin(Lamb $bot, Dog_Server $server, Dog_Channel $channel, Dog_User $user)
	{
		$cid = $channel->getID();
		$cname = $channel->getName();
		$count = $channel->getUserCount();
		$peak = self::getPeak($cid);
		$old_peak = $peak->getVar('lcpeak_peak');
		if ($count <= $old_peak)
		{
			Dog_Log::logDebug('Old channel peak was larger.');
			return;
		}
		
		if (false === $peak->savePeak($count))
		{
			Dog_Log::error('Cannot save channel peak!');
			return;
		}
		
		if ( ($old_peak > 0) && ($count > $old_peak) )
		{
			if ($peak->isEnabled())
			{
				$date = GWF_Time::displayTimestamp();
				$server->sendPRIVMSG($cname, "The new channel peak for {$cname} is {$count} on {$date}.");
			}
		}
	}
	
	public function savePeak($count)
	{
		return $this->saveVars(array(
			'lcpeak_peak' => $count,
			'lcpeak_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		));		
	}
	
	#################
	### Get / Set ###
	#################
	public static function getPeak($cid)
	{
		if (false !== ($peak = GDO::table(__CLASS__)->getRow($cid)))
		{
			return $peak;
		}
		return self::createPeak($cid);
	} 

	public static function createPeak($cid, $count=0, $options=0)
	{
		$peak = new self(array(
			'lcpeak_cid' => $cid,
			'lcpeak_peak' => $count,
			'lcpeak_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'lcpeak_options' => 0,
		));
		if (false === $peak->replace())
		{
			return false;
		}
		return $peak;
	} 
}
?>
