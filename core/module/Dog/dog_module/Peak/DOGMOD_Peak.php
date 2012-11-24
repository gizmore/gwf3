<?php
final class DOGMOD_Peak extends Dog_Module
{
	private function on_peak_Lc()
	{
		if (false === ($channel = Dog::getChannel()))
		{
			return 'This command works in channels only.';
		}
		
		if (false === ($peak = Dog_ChannelPeak::getPeak($channel->getID())))
		{
			return 'Database error!';
		}

		$date = $peak->getVar('lcpeak_date');
		$count = $peak->getVar('lcpeak_peak');
		$peakshow = $peak->isEnabled() ? 'enabled' : 'disabled';
		
		$count_now = $channel->getUserCount();
		if ($count_now > $count)
		{
			$peak->savePeak($count_now);
			$count = $count_now;
			$date = GWF_Time::getDate(GWF_Date::LEN_SECOND);
		}
		
		return sprintf('Channel peak of %d for %s has been reached on %s, %s ago. The peakshow is %s.', $count, $channel->getName(), GWF_Time::displayDate($date), GWF_Time::displayAge($date), $peakshow);
	}
	
	public function on_addpeak_Ac() { $this->onPeakEnable(true); }
	public function on_removepeak_Ac() { $this->onPeakEnable(false); }
	private function onPeakEnable($enable=true)
	{
		$channel = Dog::getChannel();
		
		if (false === ($peak = Dog_ChannelPeak::getPeak($channel->getID())))
		{
			return 'Database error.';
		}
		
		if (false === $peak->saveOption(Dog_ChannelPeak::ENABLED, $enable))
		{
			return 'Database error 2.';
		}
		
		$cname = $channel->getName();
		$bool = $enable ? 'enabled' : 'disabled';
		
		return "The peakshow for {$cname} has been {$bool}.";
	}
}
?>
