<?php
final class Shadowcmd_quests extends Shadowcmd
{
	/**
	 * Called like
	 * #quests SmithHammer
	 * #quests Lovers
	 * #quests open 1
	 * #quests open
	 * #quests done 1
	 * @param SR_Player $player
	 * @param array $args
	 */
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 0)
		{
			$args = array('open');
		}
		
		$quests = SR_Quest::getAllQuests($player);
		
		switch ($args[0])
		{
			case 'open': 
			case 'deny':
			case 'done':
			case 'fail':
			case 'abort':
				return self::displaySection($player, $quests, $args[0], $args);
			default:
				if (Common::isNumeric($args[0]))
				{
					return self::onDisplayQuestByNum($player, $quests, $args);
				}
				return self::onSearchQuests($player, $quests, $args);
		}
	}

	private static function displaySection(SR_Player $player, array $quests, $section, array $args)
	{
		$page = isset($args[1]) ? ((int)$args[1]) : 1;
		$filtered = array();
		$i = 1;
		foreach ($quests as $quest)
		{
			$quest instanceof SR_Quest;
			$bitin = SR_Quest::$QUEST_FLAGS[$section][0];
			$bitot = SR_Quest::$QUEST_FLAGS[$section][1];
			if (($quest->getOptions() & $bitin) === $bitot)
			{
				$filtered[$i] = $quest;
			}
			$i++;
		}
		return self::displayMultiple($player, $filtered, $page, $section);
	}
	
	private static function displayMultiple(SR_Player $player, array $quests, $page=1, $section='All')
	{
		$nQuests = count($quests);
		$ipp = 10;
		$nPages = GWF_PageMenu::getPagecount($ipp, $nQuests);
		$page = (int)$page;
		
		if (count($quests) === 0)
		{
			return self::reply($player, 'There are no quests here.');
		}
		if (count($quests) === 1)
		{
			$id = key($quests);
			return self::onDisplayQuest($player, $quests[$id], $id);
		}
		else
		{
			if ( ($page < 1) || ($page > $nPages) )
			{
				return self::reply($player, 'This page is empty.');
			}
			$quests = array_slice($quests, ($page-1)*10, 10, true);
			$message = '';
			foreach ($quests as $id => $quest)
			{
				$quest instanceof SR_Quest;
				$message .= sprintf(", %d-%s", $id, $quest->getQuestName());
			}
			
			if ($message === '')
			{
				return self::reply($player, 'There are no quests here.');
			}
			
			$message = sprintf('%s quests, page %d/%d: %s.',$section, $page, $nPages, substr($message, 2));
			self::reply($player, $message);
		}
	}
	
	private static function onDisplayQuestByNum(SR_Player $player, array $quests, array $args)
	{
		$id = (int)$args[0];
		if ( ($id < 1) || ($id > count($quests)) )
		{
			$player->message(sprintf('Unknown quest ID'));
			return false;
		}
		return self::onDisplayQuest($player, $quests[$id-1], $id);
	}
	
	private static function onSearchQuests(SR_Player $player, array $quests, array $args)
	{
		$page = isset($args[1]) ? ((int)$args[1]) : 1;
		
		$i = 1;
		$filtered = array();
		foreach ($quests as $quest)
		{
			$quest instanceof SR_Quest;
			
			if (stripos($quest->getQuestName(), $args[0]) !== false)
			{
				$filtered[$i] = $quest;
			}
			elseif (stripos($quest->getQuestDescription(), $args[0]) !== false)
			{
				$filtered[$i] = $quest;
			}
			
			$i++;
		}
	
		return self::displayMultiple($player, $filtered, $page, 'Browse');
	}
	
	private static function onDisplayQuest(SR_Player $player, SR_Quest $quest, $id)
	{
		$message = sprintf('%d: %s - %s', $id, $quest->getQuestName(), $quest->getQuestDescription());
		return self::reply($player, $message);
	}
	
	
	
	
	
	
// 	public static function executeOLD(SR_Player $player, array $args)
// 	{
// 		$bot = Shadowrap::instance($player);
		
// 		$quest = false;
// 		switch (count($args))
// 		{
// 			case 2:
// 				$id = $args[1];
// 				if (!is_numeric($id)) {
// 					$bot->reply(Shadowhelp::getHelp($player, 'quests'));
// 					return false;
// 				}
// 				else {
// 					if (false === ($quest = SR_Quest::getByID($player, $args[0], $id))) {
// 						$bot->reply('This quest-id is unknown.');
// 						return false;
// 					} 
// 				}
// 			case 1:
// 				$section = $args[0];
// 				if (is_numeric($section)) {
// 					if (false === ($quest = SR_Quest::getByID($player, 'accepted', $section))) {
// 						$bot->reply('This quest-id is unknown.');
// 						return false;
// 					}
// 					$section = 'open';
// 				}
// 				break;
				
// 			case 0:
// 				$section = 'open';
// 				break;
				
// 			default: $bot->reply(Shadowhelp::getHelp($player, 'quests')); return false;
				
// 		}
		
// 		# Display info
// 		if ($quest === false)
// 		{
// 			if (false === ($message = Shadowfunc::getQuests($player, $section))) {
// 				$bot->reply(Shadowhelp::getHelp($player, 'quests'));
// 				return false;
// 			}
// 			$bot->reply(sprintf('Your %s quests: %s.', $section, $message));
// 			return true;
// 		}
// 		else
// 		{
// 			$bot->reply($quest->displayQuest());
// 			return true;
// 		}
// 	}
}
?>
