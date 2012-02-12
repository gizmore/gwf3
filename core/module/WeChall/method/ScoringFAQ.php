<?php
final class WeChall_ScoringFAQ extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^scoring_faq$ index.php?mo=WeChall&me=ScoringFAQ'.PHP_EOL;
	}

	public function execute()
	{
		GWF_Website::setPageTitle($this->module->lang('pt_scorefaq'));
		GWF_Website::setMetaTags($this->module->lang('mt_scorefaq'));
		$tVars = array(
			'scoring' => new GWF_LangTrans(GWF_CORE_PATH.'module/WeChall/lang/_wc_scoring'), 
		);
		return $this->module->templatePHP('scoring_faq.php', $tVars);
	}
}
?>