<?php
/**
 * Query Vote Stats by ajax (refresh outcome)
 * @author gizmore
 */
final class Votes_Ajax extends GWF_Method
{
	public function execute()
	{
		if (false !== ($vsid = Common::getGet('vsid'))) {
			return $this->statsVoteScore($this->_module, $vsid);
		}

		if (false !== ($vmid = Common::getGet('vmid'))) {
			return $this->statsVoteMulti($this->_module, $vmid);
		}
		
		return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
	}
	
	private function statsVoteScore(Module_Votes $module, $vsid)
	{
		if (false === ($votescore = GWF_VoteScore::getByID($vsid))) {
			return $this->_module->error('err_votescore');
		}
		$cnt = $votescore->getVar('vs_count');
		$avg = $votescore->getVar('vs_avg');
		$sum = $votescore->getVar('vs_sum');
		$min = $votescore->getVar('vs_min');
		$max = $votescore->getVar('vs_max');
		return sprintf('1:%s:%s:%s:%s:%s', $cnt, $avg, $sum, $min, $max);
	}

	private function statsVoteMulti(Module_Votes $module, $vmid)
	{
		if (false === ($poll = GWF_VoteMulti::getByID($vmid))) {
			return $this->_module->error('err_poll');
		}
		
		
	}
}

?>