<?php

final class Profile_LinkSite extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^profile/link_external$ index.php?mo=Profile&me=LinkSite'.PHP_EOL;
	}

	public function execute()
	{
		return $this->templateLink();
	}
	
	private function getForm()
	{
		
	}
	
	private function templateLink()
	{
		
	}
}
?>