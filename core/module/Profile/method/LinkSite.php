<?php

final class Profile_LinkSite extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^profile/link_external$ index.php?mo=Profile&me=LinkSite'.PHP_EOL;
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'profile/link_external',
						'page_title' => 'Link Site',
						'page_meta_desc' => 'Link another site',
				),
		);
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