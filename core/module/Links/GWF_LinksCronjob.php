<?php

final class GWF_LinksCronjob extends GWF_Cronjob
{
	public static function onCronjob(Module_Links $module)
	{
//		if (self::needCheck($module))
//		{
			self::start('Links');
			self::checkLinksDown($module);
			self::end('Links');
//			$module->saveModuleVar('link_last_check', time());
//		} 
	}
	private static function checkLinksDown(Module_Links $module)
	{
		GWF_Module::loadModuleDB('Votes')->onInclude();
		$links = GDO::table('GWF_Links');
		$limit = $module->cfgCheckAmount();
		$cut = time() - $module->cfgCheckInterval(); 
		$dead = GWF_Links::DEAD;
		if (false === ($result = $links->selectObjects('*', "link_lastcheck<$cut AND link_options&$dead=0", 'link_lastcheck DESC', $limit))) {
			return self::error("Database error Links-1");
		}
		
		if (0 === ($left = count($result))) {
			return self::notice('No links to check.');
		}

		self::notice("Checking $left links.");
		foreach ($result as $link)
		{
			self::checkLinkDown($module, $link);
		}
	}
	
	private static function checkLinkDown(Module_Links $module, GWF_Links $link)
	{
		# Get HREF
		$href = $link->getVar('link_href');
		if (strpos($href, '/') === 0) {
			$href = 'http://'.GWF_DOMAIN.GWF_WEB_ROOT.substr($href, 1);
		}
		
		if (GWF_HTTP::pageExists($href))
		{
			self::notice("Checking $href ... UP");
			$link->saveVar('link_downcount', 0);
			$link->saveOption(GWF_Links::DOWN|GWF_Links::DEAD, false);
		}
		else
		{
			self::notice("Checking $href ... DOWN");
			$link->increase('link_downcount', 1);
			$bits = GWF_Links::DOWN;
			$count = $link->getVar('link_downcount');
			if ($count > GWF_Links::DOWNCOUNT_DEAD) {
				$bits |= GWF_Links::DEAD;
			}
			$link->saveOption($bits, true);
		}
		
		$link->saveVar('link_lastcheck', time());
	}
}

?>