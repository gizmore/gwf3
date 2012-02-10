<?php
final class Shadowlang
{
	private static $LANG_NPC = array();
	private static $LANG_QUEST = array();
	private static $LANG_LOCATION = array();
	private static $LANG_ITEM;
	private static $LANG_HELP;
	
	public static function getItemFile() { return self::$LANG_ITEM; }
	public static function getHelpFile() { return self::$LANG_HELP; }
	
	public static function onLoadLanguage()
	{
		$dir = Shadowrun4::getShadowDir();
		self::$LANG_NPC = array(); # flush caches too.
		self::$LANG_QUEST = array();
		self::$LANG_LOCATION = array();
		self::$LANG_HELP = new GWF_LangTrans("{$dir}/lang/help/shadowhelp");
		self::$LANG_ITEM = new GWF_LangTrans("{$dir}/lang/item/shadowitems");
	}
	
	public static function langNPC(SR_NPC $npc, SR_Player $player, $key, $args=NULL)
	{
		return self::getLangNPC($npc)->lang($player->getLangISO(), $key, $args);
	}
	
	/**
	 * Get a lang file for an NPC.
	 * @param SR_NPC $npc
	 * @return GWF_LangTrans
	 */
	private static function getLangNPC(SR_NPC $npc)
	{
		# Full classname
		$cl = $npc->getNPCClassName();
	
		# Cache hit?
		if (true === isset(self::$LANG_NPC[$cl]))
		{
			return self::$LANG_NPC[$cl];
		}
	
		# Get classname without city
		if (false === ($cls = Common::substrFrom($cl, '_', false)))
		{
			die(sprintf('NPC %s does not follow naming conventions 1!'));
		}
		$cls = strtolower($cls);
		
		# Get cityname
		if (false === ($city = $npc->getNPCCityClass()))
		{
			die(sprintf('NPC %s does not follow naming conventions 2!'));
		}
		$cityname = $city->getName();
		
		
		# Cache npcs here
		$path = sprintf('%scity/%s/lang/npc/%s/%s', Shadowrun4::getShadowDir(), $cityname, $cls, $cls);
		self::$LANG_NPC[$cl] = new GWF_LangTrans($path);

		# And return the langfile!
		return self::$LANG_NPC[$cl];
	}
	
	public static function langQuest(SR_Quest $quest, SR_Player $player, $key, $args)
	{
		return self::getLangQuest($quest)->langISO($player->getLangISO(), $key, $args);
	}
	
	/**
	 * Get a lang file for a quest.
	 * @param SR_Quest $quest
	 * @return GWF_LangTrans
	 */
	private static function getLangQuest(SR_Quest $quest)
	{
		$cl = $quest->getName();
		$cll = strtolower($cl);
		if (false === isset(self::$LANG_QUEST[$cl]))
		{
			$path = sprintf('%scity/%s/lang/quest/%s/%s', Shadowrun4::getShadowDir(), $quest->getCityName(), $cll, $cll);
			self::$LANG_QUEST[$cl] = new GWF_LangTrans($path);
		}
		return self::$LANG_QUEST[$cl];
	}
	
	
	public static function langLocation(SR_Location $location, SR_Player $player, $key, $args=NULL)
	{
		return self::getLangLocation($location)->langISO($player->getLangISO(), $key, $args);
	}

	/**
	 * Get a lang file for a location.
	 * @param SR_Quest $quest
	 * @return GWF_LangTrans
	 */
	private static function getLangLocation(SR_Location $location)
	{
		$locname = $location->getName();
		if (false === isset(self::$LANG_LOCATION[$locname]))
		{
			$llocname = strtolower(Common::substrFrom($locname, '_'));
			$cityname = $location->getCity();
			$lcityname = strtolower($cityname);
			$path = sprintf('%scity/%s/lang/location/%s/%s', Shadowrun4::getShadowDir(), $location->getCity(), $llocname, $llocname);
			self::$LANG_QUEST[$locname] = new GWF_LangTrans($path);
		}
		return self::$LANG_QUEST[$locname];
	}
}
?>