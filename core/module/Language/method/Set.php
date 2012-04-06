<?php

final class Language_Set extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^lang-to-([a-z]{2})/?$ index.php?mo=Language&me=Set&iso=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($iso = Common::getGet('iso')))
		{
			$this->module->setLanguage($iso);
		}
//		GWF_Session::commit();
		GWF_Website::redirectBack();
		die();
//		header(sprintf('Location: %s', GWF_Website::getRedirectURL()));
	}
	
}

?>
