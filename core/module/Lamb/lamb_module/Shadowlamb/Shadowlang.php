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
	
	public static function langNPC(SR_NPC $npc, $key, $args=NULL)
	{
		return self::getLangNPC($npc)->lang($key, $args);
	}
	
	/**
	 * Get a lang file for an NPC.
	 * @param SR_NPC $npc
	 * @return GWF_LangTrans
	 */
	private static function getLangNPC(SR_NPC $npc)
	{
		$cl = $npc->getNPCClassName();
		if (false === isset(self::$LANG_NPC[$cl]))
		{
			$path = sprintf('%s/lang/npc/%s/%s', Shadowrun4::getShadowDir(), $cl, $cl);
			self::$LANG_NPC[$cl] = new GWF_LangTrans($path);
		}
		return self::$LANG_NPC[$cl];
	}
	
	public static function langQuest(SR_Quest $quest, $key, $args)
	{
		return self::getLangQuest($quest)->lang($key, $args);
	}
	
	/**
	 * Get a lang file for a quest.
	 * @param SR_Quest $quest
	 * @return GWF_LangTrans
	 */
	private static function getLangQuest(SR_Quest $quest)
	{
		$cl = $quest->getName();
		if (false === isset(self::$LANG_QUEST[$cl]))
		{
			$path = sprintf('%s/lang/quest/%s/%s', Shadowrun4::getShadowDir(), $cl, $cl);
			self::$LANG_QUEST[$cl] = new GWF_LangTrans($path);
		}
		return self::$LANG_QUEST[$cl];
	}
	
	
	
	public static function langLocation()
	{
		
	}
}
?>