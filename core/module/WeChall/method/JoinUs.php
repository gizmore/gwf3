<?php
final class WeChall_JoinUs extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^join_us$ index.php?mo=WeChall&me=JoinUs'.PHP_EOL.
			'RewriteRule ^join.php$ index.php?mo=WeChall&me=JoinUs'.PHP_EOL;
	}
	
	public function execute()
	{
		$lang = new GWF_LangTrans(GWF_CORE_PATH.'module/WeChall/lang/join_us/_wc_join');
		GWF_Website::setPageTitle($lang->lang('pt_joinus'));
		GWF_Website::setMetaTags($lang->lang('mt_joinus'));
		
		$section = Common::getGetString('section', 'join');
		
		switch($section)
		{
			case 'optional': $filename = 'join_opt.php'; break;
			case 'wechall_api': $filename = 'join_api.php'; break;
			default: $filename = 'join.php'; break;
		}
		$tVars = array(
			'join' => $lang,
		);
		return $this->module->templatePHP($filename, $tVars);
	}
}
?>