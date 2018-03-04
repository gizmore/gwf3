<?php
/**
 * Some code to generate birthday stats.
 * Did a method, because gwf is not that bad, and maybe i reuse code.
 * @author gizmore
 */
final class WeChall_WC2018Stats extends GWF_Method
{
	# Admin only... the tpl code is horrible slow.
	public function getUserGroups() { return 'admin'; }
	
	public function execute()
	{
		$this->module->includeClass('WC_HistorySite');
		$this->module->includeClass('WC_HistoryUser2');
		$this->module->includeClass('WC_SolutionBlock');
		$this->module->includeClass('WC_ChallSolved');
		
		return $this->module->templatePHP('stats2018.php');
	}
}
