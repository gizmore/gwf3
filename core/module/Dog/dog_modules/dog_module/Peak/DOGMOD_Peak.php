<?php
final class DOGMOD_Peak extends Dog_Module
{
	public function getOptions()
	{
		return array(
			'peakshow' => 'c,o,b,0', # Channel, Operators, boolean, disabled
		);
	}
	
	private function getPeakshow() { return $this->getConfig('peakshow', 'c'); }
	private function hasPeakshow() { return $this->getPeakshow() > 0; }
	private function peekshowstring() { return $this->lang('peakshow_'.$this->getPeakshow()); }
	
	public function event_353() { $this->checkPeak(); }
	public function event_JOIN() { $this->checkPeak(); }
	private function checkPeak()
	{
		$channel = Dog::getChannel();
		$count = $channel->getUserCount();
		$peak = Dog_ChannelPeak::getPeak($channel);
		$old_peak = $peak->getVar('lcpeak_peak');
		if ($count > $old_peak)
		{
			if (!$peak->savePeak($count))
			{
				Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			elseif ( ($old_peak > 0) && ($this->hasPeakshow()) )
			{
				$iso = $channel->getLangISO();
				$date = GWF_Time::displayTimestamp(NULL, $iso);
				$channel->sendNOTICE($this->langISO($iso, 'new_peak', array($channel->getName(), Dog::getServer()->displayLongName(), $count, $date)));
			}
		}
	}
	
	public function on_peak_Lc()
	{
		$channel = Dog::getChannel();
		
		if (false === ($peak = Dog_ChannelPeak::getPeak($channel)))
		{
			return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		$date = $peak->getVar('lcpeak_date');
		$count = $peak->getVar('lcpeak_peak');
		$count_now = $channel->getUserCount();

		$age = GWF_Time::displayAge($date);
		$date = GWF_Time::displayDate($date);
		$args = array($count, $channel->getName(), Dog::getServer()->displayLongName(), $date, $age, $this->peekshowstring());
		$this->rply('old_peak', $args);
	}

	public function on_peakmaster_Lc()
	{
		$peak = Dog_ChannelPeak::getHighest();
		$date = $peak->getVar('lcpeak_date');
		$age = GWF_Time::displayAge($date);
		$date = GWF_Time::displayDate($date);
		$count = $peak->getVar('lcpeak_peak');
		$chan = $peak->getChannel();
		$serv = $chan->getServer();
		
		$args = array($chan->getName(), $serv->displayLongName(), $count, $date, $age);
		$this->rply('best_peak', $args);
	}
}
