<?php
final class WeChall_ScoringFAQ extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^scoring_faq$ index.php?mo=WeChall&me=ScoringFAQ'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		GWF_Website::setPageTitle($this->_module->lang('pt_scorefaq'));
		GWF_Website::setMetaTags($this->_module->lang('mt_scorefaq'));
		$tVars = array(
			'scoring' => new GWF_LangTrans(GWF_CORE_PATH.'module/WeChall/lang/_wc_scoring'), 
		);
		return $this->_module->templatePHP('scoring_faq.php', $tVars);
	}
}
?>