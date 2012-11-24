<?php
final class SR_Install
{
	public static $TABLES = array('SR_Item', 'SR_Party', 'SR_Player', 'SR_Quest', 'SR_Stats', 'SR_PlayerStats', 'SR_PlayerVar', 'SR_Bounty', 'SR_BountyStats', 'SR_BountyHistory', 'SR_KillProtect', 'SR_BazarItem', 'SR_BazarShop', 'SR_BazarHistory', 'SR_Tell', 'SR_NoShout', 'SR_Clan', 'SR_ClanBank', 'SR_ClanHistory', 'SR_ClanMembers', 'SR_ClanRequests');
	public static function onInstall($dropTable=false)
	{
		Dog_Log::debug(__METHOD__);
		
		$dir = Shadowrun4::getShadowDir();
		
		foreach (self::$TABLES as $classname)
		{
			require_once $dir.'core/'.$classname.'.php';
			if (false !== ($table = GDO::table($classname)))
			{
				Dog_Log::debug('SR_Install::onInstall('.$classname.')');
				if (false === $table->createTable($dropTable))
				{
					return false;
				}
			}
		}
		
		return true;
	}
	
	##############################
	### Language file creation ###
	##############################
	private static function getEmptyLangFile() { return '<?php'.PHP_EOL.'$lang = array('.PHP_EOL.');'.PHP_EOL.'?>'.PHP_EOL; }
	
	public static function onCreateLangFiles()
	{
		$user = new Dog_User(array('user_sid'=>'0', 'user_name'=>'__FAKE__', 'user_lang'=>'en'));
		$player = new SR_Player(array('sr4pl_uid'=>$user));
		Shadowcmd::$CURRENT_PLAYER = $player;
		
// 		$spells = SR_Spell::getSpells();
// 		ksort($spells);
// 		foreach ($spells as $name => $spell)
// 		{
// 			printf("'%s' => '%s'\n", $name, $name);
// 		}
// 		die();
		$back = self::createItemLangFile() && self::createItemTypeFile() && self::createStatUUIDFile(); # && self::createItemDataFile();
		
		Shadowcmd::$CURRENT_PLAYER = NULL;
		
		return $back;
// 		return true;
// 		return
// 			(true === self::createNPCLangFiles()) &&
// 			(true === self::createQuestLangFiles()) &&
// 			(true === self::createLocationLangFiles()) &&
// 			(true === self::createItemLangFile()) &&
// 			(true === self::createHelpLangFile());
	}
	
	
// 	private static function createNPCLangFiles()
// 	{
// 		foreach (Shadowrun4::getCities() as $city)
// 		{
// 			$city instanceof SR_City;
// 			$npcs = $city->getNPCs();
// 			if (count($npcs) === 0)
// 			{
// 				continue;
// 			}
			
// 			# NPC langdir for city
// 			$dir = sprintf('%scity/%s/lang/npc', Shadowrun4::getShadowDir(), $city->getName());
// 			if (false === GWF_File::createDir($dir))
// 			{
// 				echo GWF_HTML::err('ERR_WRITE_FILE', array($dir));
// 				return false;
// 			}
			
// 			foreach ($npcs as $npc)
// 			{
// 				if ($npc instanceof SR_TalkingNPC)
// 				{
// 					if (false === self::createNPCLangFile($city, $npc))
// 					{
// 						return false;
// 					}
// 				}
// 			}
// 		}
// 		return true;
// 	}
	
// 	private static function createNPCLangFile(SR_City $city, SR_NPC $npc)
// 	{
// 		$cl = $npc->getNPCClassName();
// 		$dir = sprintf('%scity/%s/lang/npc/%s', Shadowrun4::getShadowDir(), $city->getName(), $cl);
// 		if (false === GWF_File::createDir($dir))
// 		{
// 			echo GWF_HTML::err('ERR_WRITE_FILE', array($dir));
// 			return false;
// 		}
			
// 		$en = "{$dir}/{$cl}_en.php";
			
// 		if (true === Common::isFile($en))
// 		{
// 			$content = file_get_contents($en);
// 		}
// 		else
// 		{
// 			return GWF_File::writeFile($en, self::getEmptyLangFile());
// 		}
		
// 		if ($content === self::getEmptyLangFile())
// 		{
// 			return true;
// 		}
		
// 		# Copy english to translations.
// 		foreach (Lamb::instance()->getISOCodes() as $iso)
// 		{
// 			$p = "{$dir}/{$cl}_{$iso}.php";
			
// 			if (false === Common::isFile($p))
// 			{
// 				if (false === GWF_File::writeFile($p, $content))
// 				{
// 					return false;
// 				}
// 			}
// 		}
// 		return true;
// 	}

// 	private static function createQuestLangFiles()
// 	{
// 		$isos = Lamb::instance()->getISOCodes();
// 		$empty = self::getEmptyLangFile();
		
// 		foreach (SR_Quest::getQuests() as $quest)
// 		{
// 			$quest instanceof SR_Quest;
// 			$cl = $quest->getName();
// 			$dir = sprintf('%scity/%s/lang/quest/%s', Shadowrun4::getShadowDir(), $quest->getCityName(), $cl);
// 			if (false === GWF_File::createDir($dir))
// 			{
// 				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
// 				return false;
// 			}
			
// 			$e = "{$dir}/{$cl}_en.php";
			
// 			if (Common::isFile($e))
// 			{
// 				# Have an english?
// 				$content = file_get_contents($e);
// 			}
// 			else
// 			{
// 				# Write empty english.
// 				if (false === GWF_File::writeFile($e, $empty))
// 				{
// 					echo GWF_HTML::err('ERR_WRITE_FILE', array($p));
// 					return false;
// 				}
// 				continue;
// 			}
			
// 			# English still empty?
// 			if ($content === $empty)
// 			{
// 				continue;
// 			}
			
// // 			# Copy english content if file does not exist yet.
// // 			foreach ($isos as $iso)
// // 			{
// // 				$p = "{$path}/{$cl}_{$iso}.php";
			
// // 				if (false === Common::isFile($p))
// // 				{
// // 					if (false === GWF_File::writeFile($p, $content))
// // 					{
// // 						echo GWF_HTML::err('ERR_WRITE_FILE', array($p));
// // 						return false;
// // 					}
// // 				}
// // 			}
// 		}
		
// 		return true;
// 	}
	
// 	private static function createLocationLangFiles()
// 	{
// 		foreach (Shadowrun4::getCities() as $city)
// 		{
// 			$city instanceof SR_City;
// 			foreach ($city->getLocations() as $location)
// 			{
				
// 			}
// 		}
// 		$isos = Lamb::instance()->getISOCodes();
// 		$empty = self::getEmptyLangFile();
		
// 		foreach (SR_Quest::getQuests() as $quest)
// 		{
// 			$quest instanceof SR_Quest;
// 			$cl = $quest->getName();
// 			$path = sprintf('%s/lang/quest/%s/%s', Shadowrun4::getShadowDir(), $quest->getCityName(), $cl);
// 			if (false === GWF_File::createDir($path))
// 			{
// 				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
// 				return false;
// 			}
			
// 			$e = "{$path}/{$cl}_en.php";
			
// 			if (Common::isFile($e))
// 			{
// 				# Have an english?
// 				$content = file_get_contents($e);
// 			}
// 			else
// 			{
// 				# Write empty english.
// 				if (false === GWF_File::writeFile($e, $empty))
// 				{
// 					echo GWF_HTML::err('ERR_WRITE_FILE', array($p));
// 					return false;
// 				}
// 				continue;
// 			}
			
// 			# English still empty?
// 			if ($content === $empty)
// 			{
// 				continue;
// 			}
			
// // 			# Copy english content if file does not exist yet.
// // 			foreach ($isos as $iso)
// // 			{
// // 				$p = "{$path}/{$cl}_{$iso}.php";
			
// // 				if (false === Common::isFile($p))
// // 				{
// // 					if (false === GWF_File::writeFile($p, $content))
// // 					{
// // 						echo GWF_HTML::err('ERR_WRITE_FILE', array($p));
// // 						return false;
// // 					}
// // 				}
// // 			}
// 		}
		
// 		return true;
// 	}
	
	private static function createItemLangFile()
	{
// 		printf("%s\n", __METHOD__);
		
		$langfile = Shadowlang::getItemfile();
		
		$items = SR_Item::getAllItems();
		usort($items, array('SR_Item', 'sort_type_asc'));
		
		$old_type = '';
		
// 		printf("%s: sorted items...\n", __METHOD__);
		
		foreach (Dog_Lang::getISOCodes() as $iso)
		{
			$path = sprintf('%slang/item/shadowitems_%s.php', Shadowrun4::getShadowDir(), $iso);
			
			if (false === Common::isFile($path))
			{
				continue;
			}
			
			$out = '<?php'.PHP_EOL;
			$out .= '$lang = array('.PHP_EOL;
		
			foreach ($items as $item)
			{
				$item instanceof SR_Item;
				
				
				$type = $item->getItemType();
				if ($old_type !== $type)
				{
// 					printf("%s: New subsection %s\n", __METHOD__, $type);
					$old_type = $type;
					$out .= PHP_EOL;
					$out .= '# '.$type.PHP_EOL;
				}
				
				$key = $item->getName();
				if ($key === ($trans = $langfile->langISO($iso, $key)))
				{
// 					printf("%s: Unknown Key %s\n", __METHOD__, $key);
					$out .= sprintf("'%s' => '%s',", $key, str_replace("'", '\\\'', $trans));
				}
				else
				{
// 					printf("%s: Old Key %s\n", __METHOD__, $key);
					$out .= sprintf("'%s' => '%s',", $key, str_replace("'", '\\\'', $trans));
				}
				$out .= PHP_EOL;
				
				
				$key .= '__desc__';
				if ($key === ($trans = $langfile->langISO($iso, $key)))
				{
					$out .= sprintf("'%s' => '%s',", $key, str_replace("'", '\\\'', $item->getItemDescription()));
				}
				else
				{
					$out .= sprintf("'%s' => '%s',", $key, str_replace("'", '\\\'', $trans));
				}
				$out .= PHP_EOL;
				
			}
			$out .= ');'.PHP_EOL;
			$out .= '?>'.PHP_EOL;
			
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
		foreach (Dog_Lang::getISOCodes() as $iso)
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
	
	private static function createItemTypeFile()
	{
		$out = '<?php'."\n\$lang = array(\n";
		
		$user = new Dog_User(array('user_sid'=>'0', 'user_name'=>'__FAKE__', 'user_lang'=>'en'));
		$player = new SR_Player(array('sr4pl_uid'=>$user));
		
		$data = array();
		foreach (SR_Item::getAllItems() as $item)
		{
			$item instanceof SR_Item;
			$data[(int)$item->getItemUUID()] = $player->lang($item->displayType());
		}
		
		ksort($data);
		
		foreach ($data as $uuid => $type)
		{
			$out .= sprintf("'%d'=>'%s',\n", $uuid, $type);
		}
		$out .= ");\n?>\n";
		$outfile = Shadowrun4::getShadowDir().'data/itemtype/itemtype_en.php';
		@mkdir(dirname($outfile), 0700, true);
		file_put_contents($outfile, $out);
		return true;
	}
	
	private static function createStatUUIDFile()
	{
		return true;
	}
	
	private static function createItemDataFile()
	{
		$out = '<?php'."\n\$lang = array(\n";
		$user = new Dog_User(array('user_sid'=>'0', 'user_name'=>'__FAKE__', 'user_lang'=>'en'));
		$player = new SR_Player(array('sr4pl_uid'=>$user));
		$data = array();
		foreach (SR_Item::getAllItems() as $item)
		{
			$item instanceof SR_Item;
			$data[(int)$item->getItemUUID()] = $player->lang($item->displayPacked($player));
		}
		
		ksort($data);
		
		foreach ($data as $uuid => $type)
		{
			$out .= sprintf("'%d'=>'%s',\n", $uuid, $type);
		}
		$out .= ");\n?>\n";
		$outfile = Shadowrun4::getShadowDir().'data/itemdata/itemdata_en.php';
		@mkdir(dirname($outfile), 0700, true);
		file_put_contents($outfile, $out);
		return true;
	}
}
?>