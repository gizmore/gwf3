<?php

final class WeChall_About extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^about_wechall$ index.php?mo=WeChall&me=About'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		$lang = new GWF_LangTrans('module/WeChall/lang/_wc_about');
		GWF_Website::setPageTitle($lang->lang('about_pagetitle'));
		GWF_Website::setMetaTags($lang->lang('about_meta'));
		
		$tVars = array(
			'about' => $lang,
		);
		return $module->template('about.php', array(), $tVars);
	}
}

?>