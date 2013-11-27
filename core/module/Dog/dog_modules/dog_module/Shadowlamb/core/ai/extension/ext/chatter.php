<?php
class SR_AI_chatter extends SR_AIExtension
{
	public function ai_msg_5084(SR_RealNPC $npc, array $args) { self::chatwrapper('pm', $npc, $args); }
	public function ai_msg_5085(SR_RealNPC $npc, array $args) { self::chatwrapper('say', $npc, $args); }
	public function ai_msg_5086(SR_RealNPC $npc, array $args) { self::chatwrapper('whisper', $npc, $args); }
	private static function chatwrapper($command, SR_RealNPC $npc, array $args)
	{
		$player = self::getPlayer(array_shift($args));
// 		$npc->setChatPartner($player);
		if ($player->isHuman())
		{
			return $npc->realnpcfunc('on_'.$command, $args);
		}
	}
	
	private static function hasChatTree(SR_RealNPC $npc, SR_Player $player, $word, array $tree)
	{
		echo "hasChatTree\n";
		var_dump($tree);
		$lang = $npc->getLangNPC()->getTrans($player->getLangISO());
		$newtree = array();
 		foreach ($tree as $word)
		{
			if (!isset($lang[$word]))
			{
				$player->setChatTree($npc, array($word));
				return false;
			}
			else
			{
				$lang = $lang[$word];
			}
		}
		
		if (is_array($lang) && isset($lang[$word]))
		{
			$player->pushChatTree($npc, $word);
			return $lang[$word];
		}
		
		return $lang;
	}
	
	public static function onChatResponse(SR_RealNPC $npc, array $args)
	{
		echo $npc->getClassName().'->'.__FUNCTION__."\n";
		
		$player = $npc->getChatPartner();
		$quest = $npc->getNPCQuest($player);
		$tree = $player->getChatTree($npc, $quest);
		$word = isset($args[0])?$args[0]:'default';
		
		if (false === ($message = self::hasChatTree($npc, $player, $word, $tree)))
		{
			return $npc->onNPCTalk($player, $word, $args);
		}
		$npc->ai_reply($message);
		self::parseScriptMessage($message);
	}
	
	private static function parseScriptMessage($message)
	{
		
	}
	
	public function ai_on_say(SR_RealNPC $npc, array $args)
	{
		return self::onChatResponse($npc, $args);
	}
	
	public function ai_on_whisper(SR_RealNPC $npc, array $args)
	{
		echo ":Ochatter.ai_on_whisper(): {$npc->getClassName()}\n";
		return self::onChatResponse($npc, $args);
	}
	
// 	public function on_shout(SR_RealNPC $npc, SR_Player $player, $message)
// 	{
// 	}
	
	public function ai_on_pm(SR_RealNPC $npc, SR_Player $player, $message)
	{
	}
	
}
