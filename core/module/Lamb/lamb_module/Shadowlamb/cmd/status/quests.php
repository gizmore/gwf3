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
			case 'stats': case 's':
				return self::displayStats($player, $quests);
			case 'citystats': case 'cstats': case 'cs':
				return self::displayCityStats($player);
			default:
				if (Common::isNumeric($args[0]))
				{
					return self::onDisplayQuestByNum($player, $quests, $args);
				}
				return self::onSearchQuests($player, $quests, $args);
		}
	}
	
	private static function displayStats(SR_Player $player, array $quests)
	{
		$done = 0;
		$open = 0;
		$total = SR_Quest::getTotalQuestCount();
		$failed = 0;
		$declined = 0;
		$unknown = $total - count($quests);
		
		foreach ($quests as $quest)
		{
			$quest instanceof SR_Quest;
			if ($quest->isInQuest($player) === true)
			{
				$open++;
			}
			elseif ($quest->isDone($player) === true)
			{
				$done++;
			}
			elseif ($quest->isDeclined($player) === true)
			{
				$declined++;
			}
			elseif ($quest->isFailed($player) === true)
			{
				$failed++;
			}
			else
			{
				$unknown++;
			}
		}
		
		$message = Shadowrun4::lang('5010', array(
			$open, $done, $declined, $failed, $unknown, $total
		));
		
// 		$message = sprintf(
// 			'Quest stats: %d open, %d accomplished, %d rejected, %d failed, %d unknown from a total of %d.',
// 			$open, $done, $declined, $failed, $unknown, $total
// 		);
		
		self::reply($player, $message);
	}
	
	private static function displayCityStats(SR_Player $player)
	{
		$all = SR_Quest::getQuests();
		
		$by_city = array();
		foreach ($all as $quest)
		{
			$quest instanceof SR_Quest;
			$q2 = SR_Quest::getQuest($player, $quest->getVar('sr4qu_name'));
			
			$cityname = $quest->getCityName();
			
			if (false === isset($by_city[$cityname]))
			{
				$by_city[$cityname] = array(0, 0);
			}
			
			if ($q2->isDone($player))
			{
				$by_city[$cityname][0]++;
			}

			$by_city[$cityname][1]++;
		}
		
		$format = Shadowrun4::lang('fmt_cityquests');
		
		$out = '';
		foreach ($by_city as $cityname => $data)
		{
			list($done, $total) = $data;
			$out .= sprintf($format, $cityname, $done/$total*100);
		}
		
		if ($out === '')
		{
			self::reply($player, Shadowrun4::lang('1010'));
			return false;
		}

		$message = Shadowrun4::lang('5009', array(substr($out, 2)));
// 		$message = sprintf('Quest stats per city: %s.', substr($out, 2));
		self::reply($player, $message);
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
		
		$format = Shadowrun4::lang('fmt_quests');
		
		if (count($quests) === 0)
		{
			return self::rply($player, '1010'); # There are no quests here.
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
				return self::reply($player, Shadowrun4::lang('1009'));
			}
			$quests = array_slice($quests, ($page-1)*10, 10, true);
			$message = '';
			foreach ($quests as $id => $quest)
			{
				$quest instanceof SR_Quest;
				$b = ($quest->isAccepted($player) && !$quest->isDone($player)) ? chr(2) : '';
				$message .= sprintf($format, $b, $id, $quest->getQuestName());
			}
			
			if ($message === '')
			{
				return self::reply($player, Shadowrun4::lang('1010')); # There are no quests here.
			}
			
			$section = Shadowrun4::lang('qu_'.$section);
			
			return self::rply($player, '5069', array($section, $page, $nPages, substr($message, 2)));
// 			self::reply($player, Shadowrun4::lang('5009', array($section, $page, $nPages, substr($message, 2))));
// 			$message = sprintf('%s quests, page %d/%d: %s.', $section, $page, $nPages, substr($message, 2));
// 			self::reply($player, $message);
		}
	}
	
	private static function onDisplayQuestByNum(SR_Player $player, array $quests, array $args)
	{
		$id = (int)$args[0];
		if ( ($id < 1) || ($id > count($quests)) )
		{
			$player->msg('1010');
// 			$player->message(sprintf('Unknown quest ID'));
			return false;
		}
		return self::onDisplayQuest($player, $quests[$id-1], $id);
	}
	
	public static function onSearchQuests(SR_Player $player, array $quests, array $args)
	{
		$page = isset($args[1]) ? ((int)$args[1]) : 1;
		
		$i = 1;
		$filtered = array();
		foreach ($quests as $quest)
		{
			$quest instanceof SR_Quest;
			
			if ( ($quest->isAccepted($player)) || ($quest->isDone($player)) || ($quest->isDeclined($player)) )
			{
				if (stripos($quest->getQuestName(), $args[0]) !== false)
				{
					$filtered[$i] = $quest;
				}
				elseif (stripos($quest->getQuestDescription(), $args[0]) !== false)
				{
					$filtered[$i] = $quest;
				}
			}
			
			$i++;
		}
	
		return self::displayMultiple($player, $filtered, $page, 'Browse');
	}
	
	private static function onDisplayQuest(SR_Player $player, SR_Quest $quest, $id)
	{
		if ($quest->isUnknown($player))
		{
			return $player->msg('1010');
// 			return self::reply($player, 'This quest is unknown to you.');
		}
		$message = Shadowrun4::lang('5011', array(
			$id, $quest->getQuestName(), $quest->getQuestDescription(), $quest->getStatusString($player)
		));
// 		$message = sprintf('%d: %s - %s (%s)', $id, $quest->getQuestName(), $quest->getQuestDescription(), $quest->getStatusString($player));
		return self::reply($player, $message);
	}
}
?>
