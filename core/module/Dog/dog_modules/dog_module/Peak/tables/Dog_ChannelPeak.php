<?php
/**
 * Check the channel peak on join.
 * @author gizmore
 */
final class Dog_ChannelPeak extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_channel_peak'; }
	public function getColumnDefines()
	{
		return array(
			'lcpeak_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lcpeak_peak' => array(GDO::UINT, 0),
			'lcpeak_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'lcpeak_options' => array(GDO::UINT, 0),
		);
	}
	
	
	public function savePeak($count)
	{
		return $this->saveVars(array(
			'lcpeak_peak' => $count,
			'lcpeak_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		));		
	}
	
	public function getChannel()
	{
		return Dog_Channel::getByID($this->getVar('lcpeak_cid'));
	}
	
	##############
	### Static ###
	##############
	public static function getPeak(Dog_Channel $channel)
	{
		$cid = $channel->getID();
		if (false !== ($peak = GDO::table(__CLASS__)->getRow($cid)))
		{
			return $peak;
		}
		return self::createPeak($cid);
	}
	
	public static function getHighest()
	{
		$highest = self::getNHighest();
		return $highest[0];
	}

	public static function getNHighest($n=1, $from=0)
	{
		return self::table(__CLASS__)->selectObjects('*', '', 'lcpeak_peak DESC', $n, $from);
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
