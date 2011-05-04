<?php

final class Profile_LinkSite extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^profile/link_external$ index.php?mo=Profile&me=LinkSite'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		return $this->templateLink($module);
	}
	
	private function getForm(Module_Profile $module)
	{
		
	}
	
	private function templateLink(Module_Profile $module)
	{
		
	}
}
?>