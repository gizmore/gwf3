<?php
/**
 * Show the WCPL.
 * @author gizmore
 */
final class WeChall_License extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^wechall_license$ index.php?mo=WeChall&me=License'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return $this->templateLicense($this->_module);
	}
	
	private function templateLicense(Module_WeChall $module)
	{
		$lang = new GWF_LangTrans(GWF_CORE_PATH.'module/WeChall/lang/_wc_tos');
		GWF_Website::setPageTitle($lang->lang('pt_license'));
		
		$tVars = array(
			'license' => $lang,
		);
		return $this->_module->templatePHP('license.php', $tVars);
	}
}

?>