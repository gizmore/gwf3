<?php
final class WeChall_Rewrites extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess()
	{
		return
			'RewriteRule ^wechall_news_feed/?$ index.php?mo=News&me=Feed'.PHP_EOL. # Old feed url
			'';
	}
	
	public function execute()
	{
	}
}
?>