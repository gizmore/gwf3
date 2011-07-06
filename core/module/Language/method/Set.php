<?php

final class Language_Set extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^lang-to-([a-z]{2})/?$ index.php?mo=Language&me=Set&iso=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($iso = Common::getGet('iso')))
		{
			$module->setLanguage($iso);
		}
		GWF_Session::commit();
		GWF_Website::redirectBack();
		die();
//		header(sprintf('Location: %s', GWF_Website::getRedirectURL()));
	}
	
}

?>