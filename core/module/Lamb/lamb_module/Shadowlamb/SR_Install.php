<?php
final class SR_Install
{
	public static $TABLES = array('SR_Item', 'SR_Party', 'SR_Player', 'SR_Quest', 'SR_Stats', 'SR_PlayerStats', 'SR_PlayerVar', 'SR_Bounty', 'SR_BountyStats', 'SR_BountyHistory', 'SR_KillProtect', 'SR_BazarItem', 'SR_BazarShop', 'SR_BazarHistory', 'SR_Tell', 'SR_NoShout', 'SR_Clan', 'SR_ClanBank', 'SR_ClanHistory', 'SR_ClanMembers', 'SR_ClanRequests');
	public static function onInstall($dropTable=false)
	{
		Lamb_Log::logDebug(__METHOD__);
		
		foreach (self::$TABLES as $classname)
		{
			if (false !== ($table = GDO::table($classname)))
			{
				Lamb_Log::logDebug('SR_Install::onInstall('.$classname.')');
				if (false === $table->createTable($dropTable))
				{
					return false;
				}
			}
		}
		
		return self::onCreateLangFiles();
	}
	
	##############################
	### Language file creation ###
	##############################
	private static function getEmptyLangFile() { return '<?php'.PHP_EOL.'$lang = array('.PHP_EOL.');'.PHP_EOL.'?>'.PHP_EOL; }
	
	public static function onCreateLangFiles()
	{
		return
			(true === self::createNPCLangFiles()) &&
			(true === self::createQuestLangFiles()) &&
			(true === self::createItemLangFile()) &&
			(true === self::createHelpLangFile());
	}
	
	
	private static function createNPCLangFiles()
	{
		foreach (Shadowrun4::getCities() as $city)
		{
			$city instanceof SR_City;
			$npcs = $city->getNPCs();
			if (count($npcs) === 0)
			{
				continue;
			}
			
			$path = sprintf('%s/lang/npc/%s', Shadowrun4::getShadowDir(), $city->getName());
			if (false === GWF_File::createDir($path))
			{
				echo GWF_HTML::err('ERR_WRITE_FILE', array($path));
				return false;
			}
			
			foreach ($npcs as $npc)
			{
				if ($npc instanceof SR_TalkingNPC)
				{
					if (false === self::createNPCLangFile($city, $npc))
					{
						return false;
					}
				}
			}
		}
		return true;
	}
	
	private static function createNPCLangFile(SR_City $city, SR_NPC $npc)
	{
		$cl = $npc->getNPCClassName();
		$path = sprintf('%s/lang/npc/%s/%s', Shadowrun4::getShadowDir(), $city->getName(), $cl);
		if (false === GWF_File::createDir($path))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
			
		$en = "{$path}/{$cl}_en.php";
			
		if (true === Common::isFile($en))
		{
			$content = file_get_contents($en);
		}
		else
		{
			return GWF_File::writeFile($en, self::getEmptyLangFile());
		}
		
		if ($content === self::getEmptyLangFile())
		{
			return true;
		}
		
		# Copy english to translations.
		foreach (Lamb::instance()->getISOCodes() as $iso)
		{
			$p = "{$path}/{$cl}_{$iso}.php";
			
			if (false === Common::isFile($p))
			{
				if (false === GWF_File::writeFile($p, $content))
				{
					return false;
				}
			}
		}
		return true;
	}

	private static function createQuestLangFiles()
	{
		$isos = Lamb::instance()->getISOCodes();
		$empty = self::getEmptyLangFile();
		
		foreach (SR_Quest::getQuests() as $quest)
		{
			$quest instanceof SR_Quest;
			$cl = $quest->getName();
			$path = sprintf('%s/lang/quest/%s/%s', Shadowrun4::getShadowDir(), $quest->getCityName(), $cl);
			if (false === GWF_File::createDir($path))
			{
				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
				return false;
			}
			
			$e = "{$path}/{$cl}_en.php";
			
			if (Common::isFile($e))
			{
				# Have an english?
				$content = file_get_contents($e);
			}
			else
			{
				# Write empty english.
				if (false === GWF_File::writeFile($e, $empty))
				{
					echo GWF_HTML::err('ERR_WRITE_FILE', array($p));
					return false;
				}
				continue;
			}
			
			# English still empty?
			if ($content === $empty)
			{
				continue;
			}
			
// 			# Copy english content if file does not exist yet.
// 			foreach ($isos as $iso)
// 			{
// 				$p = "{$path}/{$cl}_{$iso}.php";
			
// 				if (false === Common::isFile($p))
// 				{
// 					if (false === GWF_File::writeFile($p, $content))
// 					{
// 						echo GWF_HTML::err('ERR_WRITE_FILE', array($p));
// 						return false;
// 					}
// 				}
// 			}
		}
		
		return true;
	}
	
	private static function createItemLangFile()
	{
		$langfile = Shadowlang::getItemfile();
		
		$items = SR_Item::getAllItems();
		usort($items, array('SR_Item', 'sort_type_asc'));
		
		foreach (Lamb::instance()->getISOCodes() as $iso)
		{
			$out = '<?php'.PHP_EOL;
			$out .= '$lang = array('.PHP_EOL;
		
			foreach ($items as $item)
			{
				$item instanceof SR_Item;
				$key = $item->getName();
				if ($key === ($trans = $langfile->langISO($iso, $key)))
				{
					$out .= sprintf("'%s' => '%s',", $key, str_replace("'", '\\\'', $trans));
				}
				else
				{
					$out .= sprintf("//'%s' => '',", $key);
				}
				$out .= PHP_EOL;
			}
			$out .= ');'.PHP_EOL;
			$out .= '?>'.PHP_EOL;
			
			$path = sprintf('%slang/item/shadowitems_%s.php', Shadowrun4::getShadowDir(), $iso);
			GWF_File::writeFile($path, $out);
		}
		
		return true;
	}
	
	private static function createHelpLangFile()
	{
		# Get current english from src.
		$help = Shadowhelp::getAllHelp();
		$help = self::prepareHelpArrayForLangFiles($help);
	
		# Update existing.
		foreach (Lamb::instance()->getISOCodes() as $iso)
		{
			$path = Shadowrun4::getShadowDir()."lang/help/shadowhelp_{$iso}.php";
			if (false === ($lang = GWF_Language::getByISO($iso)))
			{
				$lang = GWF_Language::getEnglish();
			}
				
			if (false === self::createHelpLangFileB($lang, $path, $help, false))
			{
				return false;
			}
		}
		
		# Build english from source.
		$path = Shadowrun4::getShadowDir()-'lang/item/shadowitems_en.php';
		return self::createHelpLangFileB(GWF_Language::getEnglish(), $path, $help, true);
	}

	private static function prepareHelpArrayForLangFiles(array &$help)
	{
		return $help; # TODO: Remove the nesting. 
	}

	/**
	 * On flush simply rebuild completely from source (english). On update merge the stuff nicely.
	 * @param GWF_Language $lang
	 * @param string $path
	 * @param array $help
	 * @param boolean $flush
	 * @return boolean
	 */
	private static function createHelpLangFileB(GWF_Language $lang, $path, array &$help, $flush=false)
	{
		GWF_Language::setCurrentLanguage($lang);
		# TODO: Rewrite shadowhelp lang files.
		return true;
	}

}
?>