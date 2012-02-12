<?php
/**
 * Show the WCPL.
 * @author gizmore
 */
final class WeChall_License extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^wechall_license$ index.php?mo=WeChall&me=License'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->templateLicense();
	}
	
	private function templateLicense()
	{
		$lang = new GWF_LangTrans(GWF_CORE_PATH.'module/WeChall/lang/_wc_tos');
		GWF_Website::setPageTitle($lang->lang('pt_license'));
		
		$tVars = array(
			'license' => $lang,
		);
		return $this->module->templatePHP('license.php', $tVars);
	}
}

?>